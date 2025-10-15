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
    return response()->json([
        'csrf_token' => csrf_token(),
        'session_id' => session()->getId(),
        'session_lifetime' => config('session.lifetime'),
        'session_driver' => config('session.driver')
    ]);
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
})->name('dashboard')->middleware('auth');

Route::post('/dashboard', function (Request $request) {
    // Handle email verification code
    $code = $request->input('code');
    
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
                \Log::info('Verification code mismatch for user: ' . $user->email);
                return redirect()->back()->with('error', 'Invalid verification code.');
            }
        } else {
            \Log::info('No user found for verification code: ' . $code);
            return redirect()->back()->with('error', 'User not found. Please try registering again.');
        }
    }
    
    return redirect()->route('dashboard');
})->name('dashboard.verify');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout.get');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/register/password', [RegisterController::class, 'showPasswordSetup'])->name('register.password');
Route::post('/register/password', [RegisterController::class, 'completeRegistration'])->name('register.complete');

// Email Verification Routes
Route::get('/email/verify/{token}', [RegisterController::class, 'verifyEmail'])->name('email.verify');
Route::post('/email/resend-verification', [RegisterController::class, 'resendVerification'])->name('email.resend');
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

// Password Reset Routes
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetCode'])->name('password.email');
Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password/verify-code', [PasswordResetController::class, 'verifyResetCode'])->name('password.verify.code');
Route::get('/create-new-password', [PasswordResetController::class, 'showCreatePasswordForm'])->name('password.create.form');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');
