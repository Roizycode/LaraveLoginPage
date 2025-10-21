<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;

Route::get('/', function () {
    return redirect('/login');
});

// Simple test route
Route::get('/test', function () {
    return 'Laravel is working! Time: ' . now();
});

// Debug route to check if Laravel is working
Route::get('/debug', function () {
    return response()->json([
        'status' => 'Laravel is working!',
        'app_name' => config('app.name'),
        'app_env' => config('app.env'),
        'database' => config('database.default'),
        'time' => now()
    ]);
});

// Health check route
Route::get('/health', function () {
    try {
        $checks = [
            'status' => 'OK',
            'time' => now(),
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'database' => config('database.default'),
            'storage_writable' => is_writable(storage_path()),
            'bootstrap_cache_writable' => is_writable(base_path('bootstrap/cache')),
            'database_exists' => file_exists(database_path('database.sqlite')),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version()
        ];
        
        return response()->json($checks);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'ERROR',
            'error' => $e->getMessage(),
            'time' => now()
        ], 500);
    }
});

// CSRF Token Refresh Route
Route::get('/csrf-token', function () {
    try {
        // Ensure session is started
        if (!session()->isStarted()) {
            session()->start();
        }
        
        return response()->json([
            'csrf_token' => csrf_token(),
            'session_id' => session()->getId(),
            'session_lifetime' => config('session.lifetime'),
            'session_driver' => config('session.driver'),
            'timestamp' => time()
        ]);
    } catch (Exception $e) {
        \Log::error('CSRF token generation failed: ' . $e->getMessage());
        return response()->json([
            'error' => 'Failed to generate CSRF token',
            'message' => $e->getMessage()
        ], 500);
    }
});

// Debug CSRF Route
Route::get('/debug-csrf', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'session_data' => session()->all(),
        'session_lifetime' => config('session.lifetime'),
        'session_driver' => config('session.driver'),
        'app_env' => config('app.env'),
        'app_debug' => config('app.debug')
    ]);
});

// Fallback route - redirect any undefined route to login
Route::fallback(function () {
    return redirect('/login');
});

// Dashboard Route
Route::get('/dashboard', function () {
    $user = Auth::user();
    \Log::info('Dashboard access - User: ' . ($user ? $user->email : 'null') . ', Verified: ' . ($user && $user->email_verified_at ? 'YES' : 'NO'));
    return view('dashboard');
})->name('dashboard')->middleware('auth.custom');

Route::post('/dashboard', function (Request $request) {
    // Handle email verification code
    $code = $request->input('code');
    \Log::info('Dashboard POST received - Code: ' . ($code ?: 'null') . ', Length: ' . ($code ? strlen($code) : 'null'));
    
    if ($code && strlen($code) === 6) {
        // Try to get user from session first, then from auth
        $user = null;
        if (session('user_email')) {
            $user = \App\Models\User::where('email', session('user_email'))->first();
            \Log::info('Found user from session: ' . ($user ? $user->email : 'null'));
        } elseif (Auth::user()) {
            $user = Auth::user();
            \Log::info('Found user from auth: ' . $user->email);
        }
        
        if ($user) {
            \Log::info('User verification token: ' . $user->email_verification_token . ', Code: ' . $code);
            
            // Check if user is already verified
            if ($user->email_verified_at) {
                \Log::info('User already verified: ' . $user->email);
                return redirect()->route('dashboard')->with('info', 'Email already verified.');
            }
            
            if ($user->email_verification_token === $code) {
                // Verify the user
                $user->email_verified_at = now();
                $user->email_verification_token = null;
                $user->save();
                
                \Log::info('User email verified successfully: ' . $user->email . ' at ' . $user->email_verified_at);
                
                // Log the user in if not already logged in
                if (!Auth::user()) {
                    Auth::login($user);
                }
                
                // Clear any session data
                $request->session()->forget('user_email');
                
                return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
            } else {
                \Log::info('Verification code mismatch for user: ' . $user->email . ' - Expected: ' . $user->email_verification_token . ', Got: ' . $code);
                return redirect()->route('email.verification.required')->with('error', 'The code you entered is invalid. Please check your email and try again.');
            }
        } else {
            \Log::info('No user found for verification code: ' . $code);
            return redirect()->route('email.verification.required')->with('error', 'Your session has expired. Please register again or check your email for the verification code.');
        }
    } else {
        \Log::info('Invalid code format - Code: ' . ($code ?: 'null') . ', Length: ' . ($code ? strlen($code) : 'null'));
        return redirect()->route('email.verification.required')->with('error', 'Please enter a valid 6-digit verification code.');
    }
    
    return redirect()->route('dashboard');
})->name('dashboard.verify');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'handleEmailSubmission'])->name('login.email')->middleware('guest');
Route::get('/login/password', [LoginController::class, 'showPasswordForm'])->name('login.password')->middleware('guest');
Route::post('/login/password', [LoginController::class, 'login'])->name('login.password.submit')->middleware('guest');
Route::post('/login/send-code', [LoginController::class, 'sendEmailCode'])->name('login.send.code')->middleware('guest');
Route::get('/login/verify-code', [LoginController::class, 'showVerifyCodeForm'])->name('login.verify.code')->middleware('guest');
Route::post('/login/verify-code', [LoginController::class, 'verifyEmailCode'])->name('login.verify.code.submit')->middleware('guest');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');
Route::get('/register/password', [RegisterController::class, 'showPasswordSetup'])->name('register.password')->middleware('guest');
Route::post('/register/password', [RegisterController::class, 'completeRegistration'])->name('register.complete')->middleware('guest');

// Email Verification Routes
Route::get('/email/verify/{token}', [RegisterController::class, 'verifyEmail'])->name('email.verify.token');
Route::post('/email/verify', [RegisterController::class, 'verifyEmailCode'])->name('email.verify');
Route::post('/email/resend-verification', [RegisterController::class, 'resendVerification'])->name('email.resend');
Route::post('/email/send-registration-code', [RegisterController::class, 'sendRegistrationVerificationCode'])->name('email.send.registration.code');
Route::get('/email/verification-required', [RegisterController::class, 'showEmailVerificationPage'])->name('email.verification.required');

// Debug route to check user verification status
Route::get('/debug/user/{email}', function($email) {
    $user = \App\Models\User::where('email', $email)->first();
    if ($user) {
        return response()->json([
            'email' => $user->email,
            'verified' => $user->email_verified_at ? true : false,
            'verification_date' => $user->email_verified_at,
            'verification_token' => $user->email_verification_token
        ]);
    }
    return response()->json(['error' => 'User not found']);
});

// Test route to check error handling
Route::get('/test-error', function() {
    return redirect()->back()->with('error', 'Test error message');
});

// Test route to check error handling on email verification page
Route::get('/test-email-error', function() {
    return view('auth.email-verification')->with('error', 'Test error message for email verification');
});

// Test email sending
Route::get('/test-email', function() {
    try {
        $user = \App\Models\User::first();
        if (!$user) {
            return response()->json(['error' => 'No users found']);
        }
        
        \Log::info('Testing email to: ' . $user->email);
        
        \Illuminate\Support\Facades\Mail::send('emails.verify-code', [
            'user' => $user,
            'verificationCode' => '123456'
        ], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Test Email - Verification Code');
        });
        
        \Log::info('Test email sent successfully to: ' . $user->email);
        
        return response()->json([
            'success' => true,
            'message' => 'Test email sent to ' . $user->email,
            'user_email' => $user->email
        ]);
    } catch (\Exception $e) {
        \Log::error('Test email failed: ' . $e->getMessage());
        return response()->json([
            'error' => 'Email sending failed: ' . $e->getMessage()
        ]);
    }
});


// Password Reset Routes
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetCode'])->name('password.email');
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password/verify-code', [PasswordResetController::class, 'verifyResetCode'])->name('password.verify.code');
Route::post('/reset-password/resend', [PasswordResetController::class, 'resendResetCode'])->name('password.resend');
Route::get('/create-new-password', [PasswordResetController::class, 'showCreatePasswordForm'])->name('password.create.form');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

// Quiz System Routes - All protected by auth middleware
Route::middleware(['auth.custom'])->group(function () {
    
    // Dashboard Routes
    Route::get('/dashboard/analytics', function () {
        return view('quiz.analytics');
    })->name('dashboard.analytics');
    
    // Quiz Management Routes
    Route::prefix('quizzes')->group(function () {
        Route::get('/', [App\Http\Controllers\QuizController::class, 'index'])->name('quizzes.list');
        Route::get('/create', [App\Http\Controllers\QuizController::class, 'create'])->name('quizzes.create');
        Route::post('/', [App\Http\Controllers\QuizController::class, 'store'])->name('quizzes.store');
        Route::get('/{quiz}', [App\Http\Controllers\QuizController::class, 'show'])->name('quizzes.show');
        Route::get('/{quiz}/edit', [App\Http\Controllers\QuizController::class, 'edit'])->name('quizzes.edit');
        Route::put('/{quiz}', [App\Http\Controllers\QuizController::class, 'update'])->name('quizzes.update');
        Route::delete('/{quiz}', [App\Http\Controllers\QuizController::class, 'destroy'])->name('quizzes.destroy');
        Route::post('/{quiz}/start', [App\Http\Controllers\QuizController::class, 'start'])->name('quizzes.start');
        Route::get('/{quiz}/take/{attempt}', [App\Http\Controllers\QuizController::class, 'take'])->name('quizzes.take');
        Route::post('/{quiz}/attempts/{attempt}/submit-answer', [App\Http\Controllers\QuizController::class, 'submitAnswer'])->name('quizzes.submit-answer');
        Route::post('/{quiz}/attempts/{attempt}/complete', [App\Http\Controllers\QuizController::class, 'complete'])->name('quizzes.complete');
    });
    
    // Question Bank Routes
    Route::prefix('questions')->group(function () {
        Route::get('/', [App\Http\Controllers\QuestionController::class, 'index'])->name('questions.list');
        Route::get('/create', [App\Http\Controllers\QuestionController::class, 'create'])->name('questions.create');
        Route::post('/', [App\Http\Controllers\QuestionController::class, 'store'])->name('questions.store');
        Route::get('/{question}', [App\Http\Controllers\QuestionController::class, 'show'])->name('questions.show');
        Route::get('/{question}/edit', [App\Http\Controllers\QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('/{question}', [App\Http\Controllers\QuestionController::class, 'update'])->name('questions.update');
        Route::delete('/{question}', [App\Http\Controllers\QuestionController::class, 'destroy'])->name('questions.destroy');
        Route::post('/{question}/toggle-status', [App\Http\Controllers\QuestionController::class, 'toggleStatus'])->name('questions.toggle-status');
        Route::post('/{question}/duplicate', [App\Http\Controllers\QuestionController::class, 'duplicate'])->name('questions.duplicate');
    });
    
    // Categories Routes
    Route::prefix('categories')->group(function () {
        Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.list');
        Route::get('/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
        Route::post('/', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
        Route::get('/{category}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('/{category}/toggle-status', [App\Http\Controllers\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::post('/reorder', [App\Http\Controllers\CategoryController::class, 'reorder'])->name('categories.reorder');
        Route::get('/api/categories', [App\Http\Controllers\CategoryController::class, 'getCategories'])->name('categories.api');
        Route::get('/{category}/stats', [App\Http\Controllers\CategoryController::class, 'getStats'])->name('categories.stats');
    });
    
    // Quiz Attempts Routes
    Route::prefix('attempts')->group(function () {
        Route::get('/', [App\Http\Controllers\QuizAttemptController::class, 'index'])->name('attempts.list');
        Route::get('/{attempt}', [App\Http\Controllers\QuizAttemptController::class, 'show'])->name('attempts.show');
        Route::post('/{attempt}/resume', [App\Http\Controllers\QuizAttemptController::class, 'resume'])->name('attempts.resume');
        Route::post('/{attempt}/abandon', [App\Http\Controllers\QuizAttemptController::class, 'abandon'])->name('attempts.abandon');
        Route::post('/{attempt}/grade', [App\Http\Controllers\QuizAttemptController::class, 'grade'])->name('attempts.grade');
        Route::get('/{attempt}/analytics', [App\Http\Controllers\QuizAttemptController::class, 'analytics'])->name('attempts.analytics');
        Route::get('/{attempt}/export', [App\Http\Controllers\QuizAttemptController::class, 'export'])->name('attempts.export');
        Route::get('/api/stats', [App\Http\Controllers\QuizAttemptController::class, 'getStats'])->name('attempts.stats');
    });
    
    // User Management Routes
    Route::prefix('users')->group(function () {
        Route::get('/', function () {
            return view('quiz.users.list');
        })->name('users.list');
        
        Route::get('/create', function () {
            return view('quiz.users.create');
        })->name('users.create');
        
        Route::get('/{id}/edit', function ($id) {
            return view('quiz.users.edit', compact('id'));
        })->name('users.edit');
        
        Route::get('/roles', function () {
            return view('quiz.users.roles');
        })->name('users.roles');
    });
    
    // Reports Routes
    Route::prefix('reports')->group(function () {
        Route::get('/performance', function () {
            return view('quiz.reports.performance');
        })->name('reports.performance');
        
        Route::get('/export', function () {
            return view('quiz.reports.export');
        })->name('reports.export');
        
        Route::get('/notifications', function () {
            return view('quiz.reports.notifications');
        })->name('reports.notifications');
    });
    
    // Settings Routes
    Route::prefix('settings')->group(function () {
        Route::get('/', function () {
            return view('quiz.settings.index');
        })->name('settings.index');
        
        Route::get('/themes', function () {
            return view('quiz.settings.themes');
        })->name('settings.themes');
    });
});
