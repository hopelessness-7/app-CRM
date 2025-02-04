<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\WorkerRequest;
use App\Http\Requests\WorkerUpdateRequest;
use App\Http\Resources\Worker\WorkerResource;
use App\Services\WorkerService;
use Illuminate\Http\Request;

class WorkerController extends MainController
{
    public function index(Request $request, WorkerService $service)
    {
        return $this->executeRequest(function () use ($request, $service) {
            $paginate = $request->input('paginate', 10);
            return WorkerResource::collection($service->index($paginate))->resolve();
        });
    }

    public function show(WorkerService $service, $id)
    {
        return $this->executeRequest(function () use ($service, $id) {
            return WorkerResource::make($service->show($id))->resolve();
        });
    }

    public function create(WorkerRequest $request, WorkerService $service)
    {
        return $this->executeRequest(function () use ($request, $service) {
            WorkerResource::make($service->create($request->validated()))->resolve();
        });
    }

    public function update(WorkerUpdateRequest $request, WorkerService $service, $id)
    {
        return $this->executeRequest(function () use ($request, $service, $id) {
            return WorkerResource::make($service->update($id, $request->validated()))->resolve();
        });
    }

    public function delete(WorkerService $service, $id)
    {
        return $this->executeRequest(function () use ($service, $id) {
            $service->delete($id);
        });
    }
}
