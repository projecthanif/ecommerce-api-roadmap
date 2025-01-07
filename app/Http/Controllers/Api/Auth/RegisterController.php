<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\SendOtpAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(
        public SendOtpAction $sendOtpAction,
    ) {}

    public function __invoke(RegisterUserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $user = $user->create($data);
        $response = [
            'user' => new UserResource($user),
        ];

        $this->sendOtpAction->handle($user);

        return successResponse('Registration successful', $response);
    }
}
