<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(__DIR__ . '/v1.php');
