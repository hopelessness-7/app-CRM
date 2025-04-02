<?php

namespace App\Http\Controllers\ApiV1\Auth;

use App\Action\ImageHandler;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Search\ElasticsearchRepository;
use App\Services\Auth\UserService;
use Illuminate\Http\Request;

class UserController extends AuthController
{
    protected UserService $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $searchEloquent = new ElasticsearchRepository();
        $query = $request->input('query', null);

        $searchResult = $searchEloquent->search(new User(), $query, 'email');

        return $this->sendResponse($searchResult);
    }

    public function show($id = null): ?\Illuminate\Http\JsonResponse
    {
        try {
            $user_id = $id ?? auth()->user()->id;
            $user = $this->service->show($user_id);
            return $this->sendResponse($user);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(UpdateUserRequest $request): ?\Illuminate\Http\JsonResponse
    {
        try {
            $userUpdate = $request->validated();
            $user = $this->service->update(auth()->user()->id, $userUpdate);
            return $this->sendResponse($user);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }
}
