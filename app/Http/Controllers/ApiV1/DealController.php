<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\DealRequest;
use App\Http\Resources\DealResource;
use App\Services\DealService;
use Illuminate\Http\Request;

class DealController extends MainController
{
    public function index(Request $request, DealService $service)
    {
        return $this->executeRequest(function() use ($request, $service) {
            return DealResource::collection($service->getAll($request->input('paginate', 10)))->resolve();
        });
    }

    public function getFromClient(Request $request, DealService $service, $clientId)
    {
        return $this->executeRequest(function() use ($request, $service, $clientId) {
            return DealResource::collection($service->getDealsFromClient($clientId, $request->input('paginate', 10)))->resolve();
        });
    }

    public function store(DealRequest $request, DealService $service)
    {
        return $this->executeRequest(function() use ($request, $service) {
            return DealResource::make($service->store($request->validated()))->resolve();
        });
    }

    public function show(DealService $service, $dealId)
    {
        return $this->executeRequest(function() use ($service, $dealId) {
            return DealResource::make($service->show($dealId))->resolve();
        });
    }

    public function update(DealRequest $request, DealService $service, $dealId)
    {
        return $this->executeRequest(function() use ($request, $service, $dealId) {
            return DealResource::make($service->update($dealId, $request->validated()))->resolve();
        });
    }

    public function destroy(DealService $service, $dealId)
    {
        return $this->executeRequest(function() use ($service, $dealId) {
            $service->delete($dealId);
        });
    }
}
