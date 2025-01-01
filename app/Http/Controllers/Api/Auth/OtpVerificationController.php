<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\SendOtpAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OtpVerificationController extends Controller
{

    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'otp' => 'required|min:4|max:4',
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $validatedData['email'];
        $otp = $validatedData['otp'];

        $user = User::where('email', $email)->firstOrFail();
        $cacheOtp = cache()->get($email);

        if (!$cacheOtp) {
            return errorResponse('OTP Expired');
        }

        if ($cacheOtp !== $otp) {
            return errorResponse('Invalid OTP');
        }
        $user->update([
            'email_verified_at' => now()
        ]);
        cache()->delete($email);
        return successResponse('OTP Verified');
    }
}
