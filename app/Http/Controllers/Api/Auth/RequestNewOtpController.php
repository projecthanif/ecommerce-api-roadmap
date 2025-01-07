<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\SendOtpAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RequestNewOtpController extends Controller
{
    public function __construct(
        public SendOtpAction $sendOtpAction,
    ) {}

    public function __invoke(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email|exists:users,email',
        ]);

        $user = User::where('email', $validatedData['email'])->firstOrFail();
        $this->sendOtpAction->handle($user);

        return successResponse('OTP sent to your email');
    }
}
