<?php

namespace App\Actions\Api\V1;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterNewUserAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public User $user,
    )
    {
    }

    public function execute(array $data): JsonResponse
    {
        $this->user->create($data);

        return response()->json([
            'message' => 'User created successfully'
        ], status: 201);
    }
}
