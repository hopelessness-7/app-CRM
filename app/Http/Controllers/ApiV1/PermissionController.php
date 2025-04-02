<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;

class PermissionController extends BaseController
{
    protected $service;
    protected $resourceClass = PermissionResource::class;
    protected $createRequestClass, $updateRequestClass = PermissionRequest::class;

    public function __construct(PermissionService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
}
