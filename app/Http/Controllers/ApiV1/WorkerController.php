<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\WorkerRequest;
use App\Http\Resources\Worker\WorkerResource;
use App\Services\WorkerService;
use Illuminate\Http\Request;

class WorkerController extends MainController
{
    protected WorkerService $service;

    public function __construct(WorkerService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $paginate = $request->input('paginate', 10);
            $resource = WorkerResource::collection($this->service->index($paginate))->resolve();
            return $this->sendResponse($resource);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function show($id)
    {
        try {
            $resource = WorkerResource::make($this->service->show($id))->resolve();
            return $this->sendResponse($resource);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function create(WorkerRequest $request)
    {
        try {
            $data = $request->validated();
            $resource = WorkerResource::make($this->service->create($data))->resolve();
            return $this->sendResponse($resource);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function update(WorkerRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $resource = WorkerResource::make($this->service->update((int) $id, $data))->resolve();
            return $this->sendResponse($resource);
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }

    public function delete($id)
    {
        try {
            return $this->sendResponse($this->service->delete($id));
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), $exception->getCode());
        }
    }
}
