<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function handleEmailSubmission(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            \Log::info('Login failed: User not found for email: ' . $request->email);
            throw ValidationException::withMessages([
                'email' => 'No account found for this email. Please create an account before logging in.',
            ]);
        }

        // Store email in session for password step
        $request->session()->put('login_email', $request->email);

        return redirect()->route('login.password');
    }

    public function showPasswordForm()
    {
        // Check if email exists in session
        if (!session('login_email')) {
            return redirect()->route('login')->with('error', 'Please enter your email first.');
        }

        return view('auth.login-password');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Get email from session
        $email = session('login_email') ?: $request->input('email');
        if (!$email) {
            return redirect()->route('login')->with('error', 'Please enter your email first.');
        }

        $credentials = [
            'email' => $email,
            'password' => $request->password,
        ];

        $remember = (bool) $request->boolean('remember');

        // Check if user exists and is verified
        $user = User::where('email', $credentials['email'])->first();
        
        if (!$user) {
            \Log::info('Login failed: User not found for email: ' . $credentials['email']);
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are invalid. Please check your email and password.',
            ]);
        }

        // Check if email is verified
        \Log::info('User email verification status: ' . ($user->email_verified_at ? 'VERIFIED' : 'NOT VERIFIED') . ' for ' . $user->email);
        
        if (!$user->email_verified_at) {
            \Log::info('Login attempt with unverified email: ' . $user->email);
            // Store user email in session and redirect to verification page
            $request->session()->put('user_email', $user->email);
            Auth::login($user); // Log them in temporarily for verification
            return redirect()->route('email.verification.required')->with('error', 'Please verify your email address before accessing your account.');
        }

        // Test password verification
        $passwordCheck = Hash::check($credentials['password'], $user->password);
        \Log::info('Password check for ' . $user->email . ': ' . ($passwordCheck ? 'PASS' : 'FAIL'));

        if (Auth::attempt($credentials, $remember)) {
            \Log::info('Login successful for user: ' . $user->email);
            $request->session()->regenerate();
            $request->session()->forget('login_email'); // Clear the stored email
            
            // Get user name for personalized message
            $userName = $user->name ?? 'User';
            return redirect()->intended('/dashboard')->with('success', "Thank you for logging in, {$userName}! Welcome back to your dashboard.");
        }

        \Log::info('Login failed: Auth::attempt failed for user: ' . $user->email);
        throw ValidationException::withMessages([
            'email' => 'The provided credentials are invalid. Please check your email and password.',
        ]);
    }

    public function sendEmailCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Check if user exists
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            \Log::info('Email code request failed: User not found for email: ' . $request->email);
            throw ValidationException::withMessages([
                'email' => 'No account found with this email address. If you have not registered yet, please sign up first.',
            ]);
        }

        // Generate a 6-digit verification code
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store the code in the user's email_verification_token field temporarily
        $user->email_verification_token = $verificationCode;
        $user->save();

        // Store email in session for verification step
        $request->session()->put('login_email', $request->email);

        // Send email with verification code
        try {
            Mail::send('emails.login-verification-code', [
                'code' => $verificationCode,
                'user' => $user
            ], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Your Login Verification Code');
            });

            \Log::info('Login verification code sent to: ' . $user->email);
            
            // Check if this is an AJAX request (for resend functionality)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Code sent! Check your email for the verification code.'
                ]);
            }
            
            return redirect()->route('login.verify.code')->with('success', 'A verification code has been sent to your email address.');
        } catch (\Exception $e) {
            \Log::error('Failed to send login verification code: ' . $e->getMessage());
            
            // Check if this is an AJAX request (for resend functionality)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send verification code. Please try again.'
                ]);
            }
            
            return redirect()->back()->with('error', 'Failed to send verification code. Please try again.');
        }
    }

    public function showVerifyCodeForm()
    {
        // Check if email exists in session
        if (!session('login_email')) {
            return redirect()->route('login')->with('error', 'Please enter your email first.');
        }

        return view('auth.login-verify-code');
    }

    public function verifyEmailCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        // Get email from session
        $email = session('login_email');
        if (!$email) {
            return redirect()->route('login')->with('error', 'Please enter your email first.');
        }

        // Find user
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        // Verify the code
        if ($user->email_verification_token === $request->code) {
            // Clear the verification token
            $user->email_verification_token = null;
            $user->save();

            // Log the user in
            Auth::login($user);
            $request->session()->regenerate();
            $request->session()->forget('login_email'); // Clear the stored email

            \Log::info('Email code login successful for user: ' . $user->email);
            
            // Get user name for personalized message
            $userName = $user->name ?? 'User';
            return redirect()->intended('/dashboard')->with('success', "Thank you for logging in, {$userName}! Welcome back to your dashboard.");
        }

        \Log::info('Invalid email code for user: ' . $user->email . ' - Code: ' . $request->code);
        return redirect()->back()->with('error', 'Invalid verification code. Please try again.');
    }

    public function logout(Request $request)
    {
        \Log::info('User logout initiated');
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        \Log::info('User logged out, redirecting to login');
        
        return redirect()->route('login');
    }
}


