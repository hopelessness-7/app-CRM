<?php

namespace App\Http\Controllers\ApiV1\Kanban;

use App\Http\Controllers\MainController;
use App\Http\Requests\Kanban\TeamRequest;
use App\Http\Requests\Kanban\TeamUpdateRequest;
use App\Http\Resources\Kanban\TeamResource;
use App\Services\Kanban\TeamService;
use Illuminate\Http\Request;

class TeamController extends MainController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TeamService $service)
    {
        return $this->executeRequest(function () use ($service, $request) {
            return TeamResource::collection($service->index($request->input('paginate', 10)))->resolve();
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request, TeamService $service)
    {
        return $this->executeRequest(function () use ($request, $service) {
            return TeamResource::make($service->store($request->validated()))->resolve();
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, TeamService $service)
    {
        return  $this->executeRequest(function () use ($id, $service) {
            return TeamResource::make($service->show($id))->resolve();
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamUpdateRequest $request, TeamService $service, string $id)
    {
        return $this->executeRequest(function () use ($request, $service, $id) {
            $service->update($id, $request->validated());
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamService $service, string $id)
    {
        return $this->executeRequest(function () use ($service, $id) {
            $service->delete($id);
        });
    }
}
