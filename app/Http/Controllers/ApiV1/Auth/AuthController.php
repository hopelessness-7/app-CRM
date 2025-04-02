<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Http\Controllers\MainController;

class AuthController extends MainController
{
    public function createNewToken($token): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        return $this->sendResponse([
            'access_token' => $token,
            'device_status' => true,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at ? date('Y-m-d H:i:s', strtotime($user->email_verified_at)) : null,
                'name' => $user->name,
            ]
        ]);
    }
}
