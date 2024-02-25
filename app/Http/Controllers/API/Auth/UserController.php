<?php

namespace App\Http\Controllers\API\Auth;

use App\Action\ImageHandler;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends AuthController
{
    public function index($id = null)
    {
        $user_id = $id ?? auth()->user()->id;

        $user = User::find($user_id);

        return $this->sendResponse($user);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = [
            'name' => $request->name,
        ];

        if ($request->has('avatar')) {
//            dd($request->avatar);
            ImageHandler::create($user, $request->avatar, 'users/avatar/', 'image');
        }

        $user->update($data);
        $user->avatar = $user->images->where('type', 'image')->first();

        return $user;
    }
}
