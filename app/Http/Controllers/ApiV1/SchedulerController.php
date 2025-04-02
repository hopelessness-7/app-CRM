<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\SchedulerRequest;
use App\Http\Resources\SchedulerResource;
use App\Services\SchedulerService;
use Illuminate\Http\Request;

class SchedulerController extends BaseController
{
    protected $service;
    protected $resourceClass = SchedulerResource::class;
    protected $createRequestClass = SchedulerRequest::class;
    protected $updateRequestClass = SchedulerRequest::class;

    public function __construct(SchedulerService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
}
