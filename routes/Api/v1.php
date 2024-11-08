<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Auth\CurrentUserController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('user', CurrentUserController::class);
    });

});
