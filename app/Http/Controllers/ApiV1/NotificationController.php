<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Resources\NotificationResource;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends MainController
{
    public function index(Request $request, NotificationService $service)
    {
        return $this->executeRequest(function () use ($request, $service) {
            return NotificationResource::collection($service->index($request->input('paginate', 10)))->resolve();
        });
    }

    public function show(NotificationService $service, $id)
    {
        return $this->executeRequest(function () use ($service, $id) {
            return NotificationResource::make($service->show($id))->resolve();
        });
    }
}
