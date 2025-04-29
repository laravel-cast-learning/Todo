<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponses
{
    public function successResponse(string $message,int $code = 200,mixed $data = null): JsonResponse{
        return response()->json([
            'status' => 'success',
            'code' => $code,
            'message' => $message,
            'errors' => null,
            'data' => $data
        ],$code);
    }

    public function errorResponse(string $message, int $code = 400,mixed $errors = null): JsonResponse{
        return response()->json([
            'status' => 'error',
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
            'data' => null
        ],$code);
    }

    public function notFoundResponse(): JsonResponse
    {
        return $this->errorResponse(
            message: "Not found or unauthorized!",
            code: 404,
            errors: 'Not found or unauthorized!'
        );
    }

    public function paginatedResponse(
        string $message,
        int $code = 200,
        mixed $data = null,
        LengthAwarePaginator $meta = null,
    ): JsonResponse{
        return response()->json([
            'status' => 'success',
            'code' => $code,
            'message' => $message,
            'errors' => null,
            'data' => [
                'items' => $data->items(),
                'meta' => [
                    'current_page' => $meta->currentPage(),
                    'prev' => $meta->previousPageUrl(),
                    'next' => $meta->nextPageUrl(),
                    'per_page' => $meta->perPage(),
                    'total' => $meta->total(),
                ]
            ]
        ]);
    }

}
