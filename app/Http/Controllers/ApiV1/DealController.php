<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\DealRequest;
use App\Http\Resources\DealResource;
use App\Services\DealService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DealController extends BaseController
{
    protected $service;
    protected $resourceClass = DealResource::class;
    protected $createRequestClass = DealRequest::class;
    protected $updateRequestClass = DealRequest::class;

    public function __construct(DealService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }

    public function getFromClient(Request $request, $clientId): JsonResponse
    {
        return $this->executeRequest(function() use ($request, $clientId) {
            return DealResource::collection($this->service->getDealsFromClient($clientId, $request->input('paginate', 10)))->resolve();
        });
    }
}
