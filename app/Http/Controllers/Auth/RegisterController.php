<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\MainController;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends MainController
{
    public function __invoke(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ];

        $user = User::create($data);

        return $this->sendResponse($user, 'Account has been successfully created');
    }
}
