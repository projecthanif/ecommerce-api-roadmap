<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\CurrentUserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(JwtMiddleware::class);

Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('user', CurrentUserController::class);
    });

});

Route::middleware([JwtMiddleware::class])->group(function () {

    Route::apiResource('category', CategoryController::class);

});
