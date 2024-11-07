<?php

declare(strict_types=1);

use Illuminate\Http\JsonResponse;

function successResponse(string $message, ?array $data, int $statusCode = 200): JsonResponse
{
    $response = [
        'message' => $message,
        'statusCode' => $statusCode,
    ];

    if (count($data) > 0) {
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
