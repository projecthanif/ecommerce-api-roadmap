<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Api\V1\RegisterNewUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterUserRequest;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __invoke(RegisterUserRequest $request, RegisterNewUserAction $action): JsonResponse
    {
        return $action->execute($request->validated());
    }
}
