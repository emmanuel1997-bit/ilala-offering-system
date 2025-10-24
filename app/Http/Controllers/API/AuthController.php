<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Otp;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function sendConsent(Request $request)
    {
        $request->validate(['phone' => 'required|string']);
        $code = rand(100000, 999999);
        Otp::create([
            'user_id' => $request->phone,
            'otp' => $code,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);
        return response()->json(['status' => true]);
    }

    public function verifyConsent(Request $request)
    {
        $request->validate(['phone' => 'required', 'code' => 'required']);

        $latestOtp = Otp::where('phone', $request->phone)
        ->orderBy('created_at', 'desc')
        ->first();
        if (!$latestOtp || $latestOtp->otp !== $request->code || Carbon::now()->greaterThan($latestOtp->expires_at)) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired code'], 401);
        }
        return response()->json(['status' => true, 'message' => 'Consent verified']);
    }

    public function setPin(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'pin' => 'required|digits:4'
        ]);

        $user = Member::where('phone_number', $request->phone)->first();
        $user->pin = Hash::make($request->pin);
        $user->save();
        return response()->json(['status' => true, 'message' => 'PIN set successfully']);
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'pin' => 'required|digits:4'
        ]);

        $user = Member::where('phone_number', $request->phone)->first();

        if (!$user || !Hash::check($request->pin, $user->pin)) {
            return response()->json(['status' => false, 'message' => 'Invalid PIN'], 401);
        }

        return response()->json(['status' => true,'user' => $user]);
    }
}
