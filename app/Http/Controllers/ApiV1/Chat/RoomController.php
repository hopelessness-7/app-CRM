<?php

namespace App\Http\Controllers\ApiV1\Chat;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Chat\RoomRequest;
use App\Http\Requests\Chat\RoomUpdateRequest;
use App\Http\Resources\Chat\RoomResource;
use App\Services\Chat\RoomService;

class RoomController extends BaseController
{
    protected $service;
    protected $resourceClass = RoomResource::class;
    protected $createRequestClass = RoomRequest::class;
    protected $updateRequestClass = RoomUpdateRequest::class;

    public function __construct(RoomService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
}
