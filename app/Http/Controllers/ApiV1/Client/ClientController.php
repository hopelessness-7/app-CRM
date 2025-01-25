<?php

namespace App\Http\Controllers\ApiV1\Client;

use App\Http\Controllers\MainController;
use App\Http\Requests\Client\ClientRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Services\Client\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends MainController
{
    public function index(Request $request, ClientService $service): JsonResponse
    {
        return $this->executeRequest(function () use ($request, $service) {
            return $service->get($request->input('paginate', 10));
        });
    }
    public function show(ClientService $service, $clientId): JsonResponse
    {
        return $this->executeRequest(function () use ($service, $clientId) {
            return $service->show($clientId);
        });
    }

    public function create(ClientRequest $request, ClientService $service): JsonResponse
    {
        return $this->executeRequest(function () use ($request, $service) {
            $data = $request->validated();
            return $service->create($data);
        });
    }

    public function update(ClientUpdateRequest $request, ClientService $service, $clientId): JsonResponse
    {
        return $this->executeRequest(function () use ($request, $service, $clientId) {
            $data = $request->validated();
            return $service->update($clientId, $data);
        });
    }

    public function delete(ClientService $service, $clientId): JsonResponse
    {
        return $this->executeRequest(function () use ($service, $clientId) {
            $service->delete($clientId);
        });
    }
}
