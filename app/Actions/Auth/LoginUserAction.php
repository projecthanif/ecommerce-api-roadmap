<?php

namespace App\Actions\Auth;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserAction
{
    public function handle(array $validated): JsonResponse
    {
        try {
            $attempt = JWTAuth::attempt($validated);

            if (! $attempt) {
                return response()->json([
                    'message' => 'You are not yet registered',
                    'status' => 401,
                ]);
            }

            $user = auth()->user();
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            $responsePayload = [
                'user' => new UserResource($user),
                'token' => $token,
            ];

            return successResponse('Login successfully', $responsePayload);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }
}
