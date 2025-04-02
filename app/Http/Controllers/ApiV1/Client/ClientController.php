<?php

namespace App\Http\Controllers\ApiV1\Client;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Client\ClientRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Services\Client\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends BaseController
{
    protected $service;
    protected $resourceClass = ClientRequest::class;
    protected $createRequestClass = ClientRequest::class;
    protected $updateRequestClass = ClientUpdateRequest::class;

    public function __construct(ClientService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
}
