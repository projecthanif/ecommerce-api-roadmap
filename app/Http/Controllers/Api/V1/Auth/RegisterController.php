<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\RegisterNewUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{

    public function __construct(
        public User $user
    )
    {
    }

    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $this->user->create($request->validated());
        return response()->json([
            'message' => 'User created successfully',
        ], status: 201);
    }
}
