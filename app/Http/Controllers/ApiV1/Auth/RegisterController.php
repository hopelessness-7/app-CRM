<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Http\Controllers\MainController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Auth\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;


class RegisterController extends MainController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->register($request->validated());
            return $this->sendResponse($user, 'Account has been successfully created');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }
}
