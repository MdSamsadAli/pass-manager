<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */

    public function ulogin()
    {
        return view('auth.login');
    }

    public function create(): View
    {
        return view('auth.login');
    }





    public function store(LoginRequest $request): RedirectResponse
    {

        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return back()->withErrors(['email' => 'Invalid email or password']);
        }

        $user = User::where('email', $request->email)->first();

        $otp = random_int(100000, 999999);
        $user->otp = $otp;

        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();


        Mail::to($user->email)->queue(new \App\Mail\OtpMail($otp));

        Auth::logout();

        Session::put('otp_user_id', $user->id);

        return redirect()->route('otp.form')->with('success', 'OTP sent to your email');
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
