<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\SendOtpAction;
use App\Actions\Auth\VerifyOtpAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtpVerificationController extends Controller
{
    public function __construct(
        public VerifyOtpAction $verifyOtpAction,
    )
    {
    }

    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'otp' => 'required|min:4|max:4',
        ]);

        $this->verifyOtpAction->handle($validatedData['otp']);
    }
}
