<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Action\ImageHandler;
use App\Models\User;
use App\Repositories\Search\ElasticsearchRepository;
use Illuminate\Http\Request;

class UserController extends AuthController
{
    public function search(Request $request)
    {
        $searchEloquent = new ElasticsearchRepository();
        $query = $request->input('query', null);

        $searchResult = $searchEloquent->search(new User(), $query, 'email');

        return $this->sendResponse($searchResult);
    }

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
            ImageHandler::create($user, $request->avatar, 'users/avatar/', 'image');
        }

        $user->update($data);
        $user->avatar = $user->images->where('type', 'image')->first();

        return $user;
    }
}
