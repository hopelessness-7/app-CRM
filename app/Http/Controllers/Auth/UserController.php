<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

class UserController extends AuthController
{
    public function index($id = null)
    {
        $user_id = $id ?? auth()->user()->id;

        $user = User::find($user_id);

        return $this->sendResponse($user);
    }
}
