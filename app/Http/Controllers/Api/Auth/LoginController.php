<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(LoginUserRequest $request, LoginUserAction $action): JsonResponse
    {
        $email = $request->only('email');
        $user = User::where('email', $email)->firstOrFail();
        if ($user->email_verified_at !== null) {
            return $action->handle($request->validated());
        }
        return errorResponse(
            message: 'Email is not verified',
        );
    }
}
