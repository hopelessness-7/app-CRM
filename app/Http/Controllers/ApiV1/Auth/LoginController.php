<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Notifications\NewDeviceLoginNotification;
use App\Services\Auth\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends AuthController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        try {
            // получаем устройство и ip пользователя
            $data = $request->validated();
            $data['currentDevice'] = $request->userAgent();
            $data['userIp'] = $request->ip();

            $response = $this->userService->login($data);

            if ($response['code'] == 403 || $response['code'] == 409) {
               return $this->sendResponse($response, '', $response['code']);
            }

            return $this->createNewToken($response['token']);

        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 500);
        }
    }
}
