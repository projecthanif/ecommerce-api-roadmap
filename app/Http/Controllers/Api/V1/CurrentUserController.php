<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
