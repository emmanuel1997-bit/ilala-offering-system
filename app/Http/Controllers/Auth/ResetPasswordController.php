<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    /**
     * Step 0: Show Email Form
     */
    public function showEmailForm()
    {
        return view('auth.password_email');
    }

    /**
     * Step 1: Send OTP to email
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Save OTP in Otp table
        Otp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
            'type' => 'password_reset',
        ]);

        // Log OTP for testing (remove in production)
        \Log::info("Password reset OTP for {$user->email}: $otp");
             Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
    $message->to($request->email)->subject('OTP');
});

        // Store user email in session for OTP verification
        session(['password_reset_email' => $user->email]);

        return redirect()->route('password.otp.form')->with('message', 'OTP sent to your email.');
    }

    /**
     * Step 2: Show OTP verification form
     */
    public function showOtpForm()
    {
        if (!session('password_reset_email')) {
            return redirect()->route('password.email.form')->withErrors('Please enter your email first.');
        }
        return view('auth.password_otp');
    }

    /**
     * Step 2: Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('password_reset_email');
        if (!$email) {
            return redirect()->route('password.email.form')->withErrors('Session expired. Please enter your email again.');
        }

        $user = User::where('email', $email)->first();

        $otpRecord = Otp::where('user_id', $user->id)
                        ->where('otp', $request->otp)
                        ->where('expires_at', '>=', Carbon::now())
                        ->latest()
                        ->first();

        if (!$otpRecord) {
            return back()->withErrors('Invalid or expired OTP.');
        }

        // OTP verified, allow password reset
        session(['otp_verified' => true]);

        return redirect()->route('password.reset.form')->with('message', 'OTP verified. You can now set a new password.');
    }

    /**
     * Step 3: Show Reset Password form
     */
    public function showResetForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('password.email.form')->withErrors('Please verify OTP first.');
        }

        return view('auth.password_reset');
    }

    /**
     * Step 3: Reset Password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = session('password_reset_email');
        if (!$email || !session('otp_verified')) {
            return redirect()->route('password.email.form')->withErrors('Session expired. Please try again.');
        }

        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear session
        session()->forget(['password_reset_email', 'otp_verified']);

        return redirect()->route('login')->with('message', 'Password reset successfully. You can now login.');
    }
}
