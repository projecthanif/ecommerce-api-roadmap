<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OtpVerificationController extends Controller
{

    public function __invoke(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'email' => ['required', 'exists:users,email'],
            'otp' => ['required', Rule::in(cache($request->email))],
        ]);

        User::where('email', $validatedData['email'])->first()->markEmailAsVerified();

        return successResponse('OTP Verified');
    }
}
