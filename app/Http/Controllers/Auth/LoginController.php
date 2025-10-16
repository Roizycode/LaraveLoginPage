<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

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
            return redirect()->intended('/dashboard')->with('success', 'Welcome back! You have successfully logged in.');
        }

        \Log::info('Login failed: Auth::attempt failed for user: ' . $user->email);
        throw ValidationException::withMessages([
            'email' => 'The provided credentials are invalid. Please check your email and password.',
        ]);
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


