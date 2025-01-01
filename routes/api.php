<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Auth\CurrentUserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\OtpVerificationController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::post('verify', OtpVerificationController::class);

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('user', CurrentUserController::class);
    });

});

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('brand', BrandController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('cart', CartController::class);
});

