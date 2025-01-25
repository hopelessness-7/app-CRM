<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\SchedulerRequest;
use App\Http\Resources\SchedulerResource;
use App\Models\Scheduler;
use App\Services\SchedulerService;
use Illuminate\Http\Request;

class SchedulerController extends MainController
{
    public function index(Request $request, SchedulerService $service)
    {
        return $this->executeRequest(function() use ($request, $service) {
            return SchedulerResource::collection($service->index($request))->resolve();
        });
    }

    public function store(SchedulerRequest $request, SchedulerService $service)
    {
        return $this->executeRequest(function() use ($request, $service) {
            return SchedulerResource::make($service->store($request->validated()))->resolve();
        });
    }

    public function show(SchedulerService $service, $id)
    {
        return $this->executeRequest(function() use ($service, $id) {
            return SchedulerResource::make($service->show($id))->resolve();
        });
    }

    public function update(SchedulerRequest $request, SchedulerService $service, $id)
    {
        return $this->executeRequest(function() use ($request, $service, $id) {
            return SchedulerResource::make($service->update($id, $request->validated()))->resolve();
        });
    }

    public function destroy(SchedulerService $service, $id)
    {
        return $this->executeRequest(function() use ($service, $id) {
            $service->destroy($id);
        });
    }
}
