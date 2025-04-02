<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;

class RoleController extends BaseController
{
    protected $service;
    protected $resourceClass = RoleResource::class;
    protected $createRequestClass, $updateRequestClass = RoleRequest::class;

    public function __construct(RoleService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
}
