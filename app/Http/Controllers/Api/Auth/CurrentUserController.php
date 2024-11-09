<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

class CurrentUserController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];
        return successResponse(message: "User info", data: $data);
    }
}
