<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Http\Controllers\Api\Auth\CurrentUserController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\OtpVerificationController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\RequestNewOtpController;
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
    Route::post('new-otp', RequestNewOtpController::class);

    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('user', CurrentUserController::class);
        // Route::patch('/update-user', function () {
        //     $res = auth()->user()->update([
        //         'role' => UserRole::Admin->value,
        //     ]);

        //     if ($res) {
        //         return successResponse("Updated");
        //     }

        //     errorResponse("Failed");
        // });
    });

});

Route::get('product', [ProductController::class, 'index']);
Route::get('product/{id}', [ProductController::class, 'show']);
Route::get('brand', [BrandController::class, 'index']);
Route::get('category', [CategoryController::class, 'index']);
Route::get('category/{id}', [CategoryController::class, 'show']);

Route::middleware([JwtMiddleware::class])->group(function () {

    Route::apiResource('brand', BrandController::class)->except('show', 'index');
    Route::apiResource('product', ProductController::class)->except('index', 'show');
    Route::apiResource('cart', CartController::class);
});

Route::middleware(['jwtAuth', 'adminAuth'])->group(function () {

    Route::post('/category', [CategoryController::class, 'store']);
    Route::patch('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'destroy']);

});
