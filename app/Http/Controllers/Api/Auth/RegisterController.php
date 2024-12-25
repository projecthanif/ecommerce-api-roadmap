<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{

    public function __invoke(RegisterUserRequest $request, User $user): JsonResponse
    {
        $user = $user->create($request->validated());

        $response = [
            'user' => new UserResource($user),
        ];

        return successResponse("Registration successful", $response);
    }
}
