<?php

namespace App\Actions\Api\V1;

use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserAction
{
    public function execute(array $validated):JsonResponse
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

            return response()->json([
                'token' => $token,
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }


}
