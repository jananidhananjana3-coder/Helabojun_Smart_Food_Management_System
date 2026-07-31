<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpVerificationController extends Controller
{
    /**
     * Show OTP verification page
     */
    public function index()
    {
        return view('auth.verify-otp');
    }


    /**
     * Verify OTP code
     */
    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();

        if ($user->verification_code == $request->verification_code) {

            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->save();

            return redirect('/dashboard')
                ->with('success', 'Email verification successful!');
        }

        return back()->withErrors([
            'verification_code' => 'Invalid verification code.'
        ]);
    }
}