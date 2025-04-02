<?php

namespace App\Http\Controllers\ApiV1\Kanban;

use App\Http\Controllers\MainController;
use App\Http\Requests\Kanban\TaskRequest;
use App\Http\Requests\Kanban\TaskUpdateRequest;
use App\Http\Resources\Kanban\TaskResource;
use App\Services\Kanban\TaskService;
use Illuminate\Http\Request;

class TaskController extends MainController
{
    public function index(Request $request, TaskService $service, $dashboardId)
    {
        return $this->executeRequest(function () use ($request, $service, $dashboardId) {
            return TaskResource::collection($service->get($request->input('paginate', 10), $dashboardId))->resolve();
        });
    }
    public function show(TaskService $service, $id)
    {
        return $this->executeRequest(function () use ($service, $id) {
            return TaskResource::make($service->show($id))->resolve();
        });
    }
    public function create(TaskRequest $request, TaskService $service)
    {
        return $this->executeRequest(function () use ($request, $service) {
            return TaskResource::make($service->store($request->validated()))->resolve();
        });
    }
    public function update(TaskUpdateRequest $request, TaskService $service, $id)
    {
        return $this->executeRequest(function () use ($request, $service, $id) {
            return TaskResource::make($service->update($id, $request->validated()));
        });
    }
    public function delete(TaskService $service, $id)
    {
        return $this->executeRequest(function () use ($service, $id) {
            $service->delete($id);
        });
    }
}
