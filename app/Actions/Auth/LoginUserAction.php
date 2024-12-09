<?php

namespace App\Actions\Auth;

use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserAction
{
    public function handle(array $validated): JsonResponse
    {
        try {
            $attempt = JWTAuth::attempt($validated);

            if (!$attempt) {
                return response()->json([
                    'message' => 'You are not yet registered',
                    'status' => 401,
                ]);
            }

            $user = auth()->user();
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            $responsePayload = [
                'token' => $token,
                'type' => 'bearer',
                'expires' => '60 min'
            ];

            return successResponse('Logged in Successfully', $responsePayload);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }
}
