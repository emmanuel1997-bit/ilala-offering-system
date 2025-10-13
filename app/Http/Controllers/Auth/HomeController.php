<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        Otp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);
        \Log::info("otp: $otp");

        // TODO: send OTP via email/SMS
        // sendSms($otp, $user->mobile);

        session(['otp_user_id' => $user->id]);

        return redirect()->route('otp')->with('message', 'OTP sent to your phone/email.');
    }

    public function showOtpForm()
    {
        if (!session()->has('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $user_id = session('otp_user_id');
        $otp = Otp::where('user_id', $user_id)
                  ->where('otp', $request->otp)
                  ->where('used', false)
                  ->where('expires_at', '>', Carbon::now())
                  ->first();

        if (!$otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        $otp->used = true;
        $otp->save();

        $user = User::find($user_id);

        // Log the user in
         Auth::login($user);


        session()->forget('otp_user_id');

        return redirect()->route('home');
    }
    public function logout(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        // Redirect to login page with success message
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }


}
