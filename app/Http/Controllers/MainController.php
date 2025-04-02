<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaginatedResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class MainController extends Controller
{
    /**
     * success response method.
     *
     * @param mixed $result
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendResponse(mixed $result, string $message = 'request completed successfully', int $code = 200): JsonResponse
    {
        if ($result instanceof PaginatedResource) {
            // Преобразуем ресурс в массив
            $resultArray = $result->resolve();

            // Формируем ответ
            $response = [
                'data' => $resultArray['data'] ?? $resultArray,
                'meta' => $resultArray['meta'] ?? null,
                'links' => $resultArray['links'] ?? null,
                'message' => $message,
                'code' => $code,
            ];
        } else {
            // Формируем ответ для обычных данных
            $response = [
                'data' => $result,
                'message' => $message,
                'code' => $code,
            ];
        }

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error, int $code = 404): JsonResponse
    {
        $response = [
            'errors' => [
                'error' => $error,
                'code' => $code
            ],
        ];

        return response()->json($response, $code);
    }

    /**
     * @param $callback
     * @return JsonResponse
     */
    public function executeRequest($callback): JsonResponse
    {
//        try {
            return $this->sendResponse($callback());
//        } catch (\Exception $e) {
//            return $this->sendError($e->getMessage(), $e->getCode());
//        }
    }
}
