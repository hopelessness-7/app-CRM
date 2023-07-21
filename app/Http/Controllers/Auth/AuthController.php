<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\MainController;

class AuthController extends MainController
{
    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => [
                'id' => auth()->user()->id,
                'email' => auth()->user()->email,
                'email_verified_at' => auth()->user()->email_verified_at ? date('Y-m-d H:i:s', strtotime(auth()->user()->email_verified_at)) : null,
                'name' => auth()->user()->name,
            ]
        ]);
    }
}
