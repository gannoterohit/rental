<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    /**
     * Send success response.
     */
    public function sendSuccess($data, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Send error response.
     */
    public function sendError(string $message, $errors = [], int $code = 404): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * User-safe error message — logs technical details, returns friendly copy.
     */
    protected function safeErrorMessage(\Throwable $e, string $fallback = 'Something went wrong. Please try again.'): string
    {
        \Illuminate\Support\Facades\Log::error($e->getMessage(), ['exception' => $e]);

        return config('app.debug') ? $e->getMessage() : $fallback;
    }
}
