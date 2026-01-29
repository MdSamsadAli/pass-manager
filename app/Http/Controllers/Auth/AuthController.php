<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showOtpForm()
    {
        return view('otpform');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user = User::find(session('otp_user_id'));

        if (!$user) {
            return redirect()->route('login')->withErrors(['otp' => 'Session expired']);
        }

        if ($user->otp !== $request->otp || $user->otp_expires_at < now()) {
            return redirect()->route('login')->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
            'is_otp_verified' => true,
        ]);

        Auth::login($user);
        session()->forget('otp_user_id');

        return redirect()->route('dashboard')->with('success', "Otp verify successfully. You're logged in");
    }
}
