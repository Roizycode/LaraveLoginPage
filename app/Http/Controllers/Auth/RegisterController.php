<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showEmailVerificationPage()
    {
        return view('auth.email-verification');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        // Check if user already exists
        $existingUser = User::where('email', $request->email)->first();
        
        if ($existingUser) {
            // If user exists and is already verified, redirect to login
            if ($existingUser->email_verified_at) {
                return redirect()->route('login')->with('info', 'An account with this email already exists. Please log in.');
            }
            
            // If user exists but not verified, allow them to continue with password setup
            // This handles the case where someone started registration but didn't complete it
        }

        // Store user data in session for password setup
        $request->session()->put('user_name', $request->name);
        $request->session()->put('user_email', $request->email);

        return redirect()->route('register.password');
    }

    public function showPasswordSetup()
    {
        // Check if user data exists in session
        if (!session('user_name') || !session('user_email')) {
            return redirect()->route('register')->with('error', 'Please complete registration first.');
        }

        return view('auth.setup-password');
    }

    public function completeRegistration(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Get user data from session
        $name = session('user_name');
        $email = session('user_email');

        if (!$name || !$email) {
            return redirect()->route('register')->with('error', 'Session expired. Please register again.');
        }

        // Check if user already exists
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            // If user exists and is already verified, redirect to login
            if ($existingUser->email_verified_at) {
                return redirect()->route('login')->with('info', 'An account with this email already exists. Please log in.');
            }
            
            // If user exists but not verified, update the existing user instead of creating new one
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $hashedPassword = Hash::make($request->password);
            
            \Log::info('Updating existing unverified user with email: ' . $email);
            
            $existingUser->update([
                'name' => $name,
                'password' => $hashedPassword,
                'email_verification_token' => $verificationCode,
            ]);
            
            $user = $existingUser;
            \Log::info('Existing user updated successfully: ' . $user->email);
        } else {
            // Generate a 6-digit verification code
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Create user with the provided password
            $hashedPassword = Hash::make($request->password);
            \Log::info('Creating new user with email: ' . $email . ', password length: ' . strlen($request->password));
            
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'email_verification_token' => $verificationCode,
                'email_verified_at' => null,
            ]);
            
            \Log::info('New user created successfully: ' . $user->email);
        }

        // Send verification code email
        $this->sendVerificationCodeEmail($user, $verificationCode);

        // Clear session data
        $request->session()->forget(['user_name', 'user_email']);

        // Store user email in session for verification
        $request->session()->put('user_email', $user->email);

        // Log the user in before redirecting to verification page
        Auth::login($user);

        return redirect()->route('email.verification.required');
    }


    public function verifyEmail($token)
    {
        try {
            $user = User::where('email_verification_token', $token)->first();

            if (!$user) {
                return redirect()->route('login')->with('error', 'Invalid verification token.');
            }

            if ($user->email_verified_at) {
                return redirect()->route('login')->with('info', 'Email already verified. You can now log in.');
            }

            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            // Log the user in automatically after email verification
            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Account created successfully! Email verified. Welcome!');
        } catch (\Exception $e) {
            \Log::error('Email verification error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Something went wrong during email verification. Please try again.');
        }
    }

    public function verifyEmailCode(Request $request)
    {
        try {
            $request->validate([
                'code' => ['required', 'string', 'size:6']
            ]);

            // Get user from session or auth
            $user = Auth::user();
            
            // If not authenticated, try to find user by email from session
            if (!$user && session('user_email')) {
                $user = User::where('email', session('user_email'))->first();
            }

            if (!$user) {
                return redirect()->route('email.verification.required')->with('error', 'User not found. Please try registering again.');
            }

            if ($user->email_verified_at) {
                return redirect()->route('dashboard')->with('info', 'Email already verified.');
            }

            // Verify the code matches
            if ($user->email_verification_token !== $request->code) {
                return redirect()->route('email.verification.required')->with('error', 'Invalid or expired verification code.');
            }

            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            // Log the user in automatically
            Auth::login($user);

            // Clear session data
            $request->session()->forget('user_email');

            return redirect()->route('dashboard')->with('success', 'Email verified successfully!');
        } catch (\Exception $e) {
            \Log::error('Email verification code error: ' . $e->getMessage());
            return redirect()->route('email.verification.required')->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function verifyCode(Request $request)
    {
        try {
            $request->validate([
                'code' => ['required', 'string', 'size:6']
            ]);

            // Get user from session or auth
            $user = Auth::user();
            
            // If not authenticated, try to find user by email from session
            if (!$user && session('user_email')) {
                $user = User::where('email', session('user_email'))->first();
            }

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found. Please try registering again.'
                ]);
            }

            if ($user->email_verified_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email already verified.'
                ]);
            }

            // Verify the code matches
            if ($user->email_verification_token !== $request->code) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid verification code.'
                ]);
            }

            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            // Log the user in automatically
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Email verification code error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ]);
        }
    }

    public function resendVerification(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', 'exists:users,email']
            ]);

            $user = User::where('email', $request->email)->first();

            if ($user->email_verified_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email already verified. You can log in.'
                ]);
            }

            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->update(['email_verification_token' => $verificationCode]);

            $this->sendVerificationCodeEmail($user, $verificationCode);

            return response()->json([
                'success' => true,
                'message' => 'Verification email sent! Please check your email.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Resend verification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ]);
        }
    }

    private function sendVerificationEmail($user, $token)
    {
        try {
            $verificationUrl = route('email.verify', $token);
            
            Mail::send('emails.verify-email', [
                'user' => $user,
                'verificationUrl' => $verificationUrl
            ], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Verify Your Email Address');
            });
        } catch (\Exception $e) {
            \Log::error('Email sending error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function sendVerificationCodeEmail($user, $code)
    {
        try {
            Mail::send('emails.verify-code', [
                'user' => $user,
                'verificationCode' => $code
            ], function ($message) use ($user) {
                $message->to($user->email, $user->name)
                        ->subject('Your Verification Code');
            });
        } catch (\Exception $e) {
            \Log::error('Email sending error: ' . $e->getMessage());
            throw $e;
        }
    }
}
