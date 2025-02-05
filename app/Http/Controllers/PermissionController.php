<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return PermissionResource::collection(Permission::all());
    }

    public function store(PermissionRequest $request)
    {
        return new PermissionResource(Permission::create($request->validated()));
    }

    public function show(Permission $permission)
    {
        return new PermissionResource($permission);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());

        return new PermissionResource($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return response()->json();
    }
}
