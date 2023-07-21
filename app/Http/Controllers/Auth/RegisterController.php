<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\MainController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;


class RegisterController extends MainController
{
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        // передаём значения для валидации данных
        $request->merge(['action' => 'register']);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ];

        $user = User::create($data);

        event(new Registered($user));

        return $this->sendResponse($user, 'Account has been successfully created');
    }
}
