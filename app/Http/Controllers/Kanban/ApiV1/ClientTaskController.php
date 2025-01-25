<?php

namespace App\Http\Controllers\Kanban\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\Kanban\ClientTaskRequest;
use App\Services\Kanban\ClientTaskService;
use Illuminate\Http\JsonResponse;

class ClientTaskController extends MainController
{
    public function setClientFromTask(ClientTaskRequest $request, ClientTaskService $service): JsonResponse
    {
        return $this->executeRequest(function () use ($request, $service) {
            $data = $request->validated();
            return $service->setClientFromTask($data);
        });
    }

    public function deleteClientFromTask(ClientTaskRequest $request, ClientTaskService $service): JsonResponse
    {
        return $this->executeRequest(function () use ($request, $service) {
            $data = $request->validated();
            $service->deleteClientFromTask($data);
        });
    }
}
