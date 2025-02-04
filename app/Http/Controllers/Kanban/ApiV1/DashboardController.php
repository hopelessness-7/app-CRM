<?php

namespace App\Http\Controllers\Kanban\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\Kanban\DashboardRequest;
use App\Http\Requests\Kanban\DashboardUpdateRequest;
use App\Http\Resources\Kanban\DashboardResource;
use App\Services\Kanban\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DashboardService $service)
    {
        return $this->executeRequest(function () use ($service, $request) {
            return DashboardResource::collection($service->getDashboard($request->input('paginate', 10)))->resolve();
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DashboardRequest $request, DashboardService $service)
    {
        return $this->executeRequest(function () use ($request, $service) {
            return DashboardResource::make($service->store($request->validated()))->resolve();
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, DashboardService $service)
    {
        return  $this->executeRequest(function () use ($id, $service) {
            return DashboardResource::make($service->show($id))->resolve();
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DashboardUpdateRequest $request, DashboardService $service, string $id)
    {
        return $this->executeRequest(function () use ($request, $service, $id) {
            return DashboardResource::make($service->update($id, $request->validated()))->resolve();
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DashboardService $service, string $id)
    {
        return $this->executeRequest(function () use ($service, $id) {
           $service->delete($id);
        });
    }
}
