<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class PasswordResetController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email']
        ]);

        $user = User::where('email', $request->email)->first();
        
        // Generate 6-digit code
        $resetCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store code in cache for 15 minutes
        Cache::put('password_reset_' . $user->email, $resetCode, 900);
        \Log::info('Reset code generated for ' . $user->email . ': ' . $resetCode);
        
        // Send password reset code email
        $this->sendResetCodeEmail($user, $resetCode);

        // Store user email in session for resend functionality
        $request->session()->put('reset_user_email', $user->email);

        return redirect()->route('password.reset.form');
    }

    public function showResetForm()
    {
        return view('auth.reset-password-code');
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6']
        ]);

        // Find user by checking all users for the reset code
        $users = User::all();
        $user = null;
        
        foreach ($users as $u) {
            $cachedCode = Cache::get('password_reset_' . $u->email);
            \Log::info('Checking user ' . $u->email . ' - Cached code: ' . ($cachedCode ?: 'null') . ', Request code: ' . $request->code);
            if ($cachedCode && $cachedCode === $request->code) {
                $user = $u;
                break;
            }
        }

        if (!$user) {
            \Log::info('Reset code verification failed: Code ' . $request->code . ' not found in cache');
            return redirect()->back()->with('error', 'Invalid or expired reset code.');
        }

        // Store the reset code in session for the next step
        $request->session()->put('reset_code', $request->code);
        $request->session()->put('reset_user_email', $user->email);

        \Log::info('Reset code verified for user: ' . $user->email);

        return redirect()->route('password.create.form');
    }

    public function showCreatePasswordForm()
    {
        // Check if reset code exists in session
        if (!session('reset_code') || !session('reset_user_email')) {
            return redirect()->route('password.reset.form')->with('error', 'Please verify your reset code first.');
        }

        return view('auth.create-new-password');
    }

    public function resetPassword(Request $request)
    {
        // Get user data from session
        $userEmail = session('reset_user_email');
        $resetCode = session('reset_code');

        if (!$userEmail || !$resetCode) {
            return redirect()->route('password.reset.form')->with('error', 'Session expired. Please verify your code again.');
        }

        $request->validate([
            'password' => [
                'required', 
                'confirmed', 
                'min:8'
            ]
        ]);

        $user = User::where('email', $userEmail)->first();
        
        if (!$user) {
            return redirect()->route('password.reset.form')->with('error', 'User not found.');
        }

        // Verify the reset code is still valid
        $cachedCode = Cache::get('password_reset_' . $user->email);
        if (!$cachedCode || $cachedCode !== $resetCode) {
            return redirect()->route('password.reset.form')->with('error', 'Reset code has expired. Please request a new one.');
        }

        // Check if the new password is the same as the current password
        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'The new password must be different from your current password. Please choose a different password.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Clear the reset code and session data
        Cache::forget('password_reset_' . $user->email);
        $request->session()->forget(['reset_code', 'reset_user_email']);

        \Log::info('Password reset successful for user: ' . $user->email);

        return redirect()->route('login')->with('success', 'Password reset successfully! You can now log in.');
    }

    public function resendResetCode(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email', 'exists:users,email']
            ]);

            $user = User::where('email', $request->email)->first();
            
            // Generate new 6-digit code
            $resetCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Store code in cache for 15 minutes
            Cache::put('password_reset_' . $user->email, $resetCode, 900);
            \Log::info('Reset code regenerated for ' . $user->email . ': ' . $resetCode);
            
            // Send password reset code email
            $this->sendResetCodeEmail($user, $resetCode);

            return response()->json([
                'success' => true,
                'message' => 'Code sent! Check your email for the new verification code.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Resend reset code error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.'
            ]);
        }
    }

    private function sendResetCodeEmail($user, $code)
    {
        Mail::send('emails.password-reset-code', [
            'user' => $user,
            'code' => $code
        ], function ($message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Password Reset Code');
        });
    }
}
