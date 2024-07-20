<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Models\User;
use App\Notifications\NewDeviceLoginNotification;
use App\Services\Auth\CodeConfirmService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class ConfirmationCodeController extends AuthController
{
    protected CodeConfirmService $service;
    public function __construct(CodeConfirmService $service)
    {
        $this->service = $service;
    }

    public function confirmationCode(Request $request): JsonResponse
    {
        try {
            $userId = $request->user_id;
            $code = $request->confirmation_code;
            $currentDevice = $request->userAgent();
            $data = $this->service->confirmation($userId, $currentDevice, $code);
            return $this->sendResponse($data, 'Authorization of the new device was successful');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function newConfirmationCode(Request $request):  JsonResponse
    {
        try {
            $userId = $request->user_id;
            $this->service->newCode($userId);
            return $this->sendResponse([], 'A message with new codes has been sent');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }
}
