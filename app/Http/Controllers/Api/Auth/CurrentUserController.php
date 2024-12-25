<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;

class CurrentUserController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $data = new UserResource($user);

        return successResponse(message: 'User info', data: $data);
    }
}
