<?php

namespace App\Http\Controllers\Chat\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\Chat\RoomRequest;
use App\Http\Resources\Chat\RoomResource;
use App\Services\Chat\RoomService;
use Illuminate\Http\Request;

class RoomController extends MainController
{
    public function index(Request $request, RoomService $service)
    {
        return $this->executeRequest(function () use ($request, $service) {
            return RoomResource::collection($service->get($request->input('paginate', 10)))->resolve();
        });
    }

    public function show(Request $request, RoomService $service, $roomId)
    {
        return $this->executeRequest(function () use ($request, $service, $roomId) {
            return RoomResource::make($service->show($roomId))->resolve();
        });
    }

    public function create(RoomRequest $request, RoomService $service)
    {
        return $this->executeRequest(function () use ($request, $service) {
            $data = $request->validated();
            return RoomResource::make($service->create($data))->resolve();
        });
    }

    /**
     * @throws \Exception
     */
    public function update(RoomService $service, RoomUpdateRequest $request, $roomId)
    {
        return $this->executeRequest( function () use ($request, $service, $roomId) {
            $data = $request->validated();
            return RoomResource::make($service->update($roomId, $data))->resolve();
        });
    }

    public function delete(Request $request, RoomService $service, $roomId)
    {
        return $this->executeRequest(function () use ($request, $service, $roomId) {
            $service->delete($roomId);
        });
    }
}
