<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('register', RegisterController::class);
//Route::post('register', RegisterController::class);

Route::middleware('api')->group(function () {});
