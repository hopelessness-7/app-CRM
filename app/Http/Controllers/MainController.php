<?php

namespace App\Http\Controllers;

class MainController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse(mixed $result, string $message = 'request completed successfully', int $code = 200)
    {
        $response = [
            'data'    => $result,
            'message' => $message,
            'code' => $code
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $code = 404)
    {
        $response = [
            'errors' => [
                'error' => $error,
                'code' => $code
            ],
        ];

        return response()->json($response, $code);
    }

    public function executeRequest($callback)
    {
//        try {
            return $this->sendResponse($callback());
//        } catch (\Exception $e) {
//            return $this->sendError($e->getMessage(), $e->getCode());
//        }
    }
}
