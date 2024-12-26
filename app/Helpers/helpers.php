<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

function successResponse(string $message, null|array|JsonResource $data = null, int $statusCode = 200): JsonResponse
{
    $response = [
        'status' => $statusCode,
        'message' => $message,
    ];

    if ($data !== null) {
        $response['data'] = $data;
    }

    return response()->json($response, status: $statusCode);
}

function errorResponse(string $message, int $statusCode = 400): JsonResponse
{
    return response()->json([
        'message' => $message,
        'statusCode' => $statusCode,
    ], status: $statusCode);
}
