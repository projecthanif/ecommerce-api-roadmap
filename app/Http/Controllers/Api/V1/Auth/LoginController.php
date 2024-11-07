<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Api\V1\LoginUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginUserRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{

    public function __invoke(LoginUserRequest $request, LoginUserAction $action): JsonResponse
    {
        return $action->execute($request->validated());
    }
}
