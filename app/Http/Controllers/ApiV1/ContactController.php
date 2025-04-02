<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\BaseController;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Services\Contact\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends BaseController
{
    protected $service;
    protected $resourceClass = ContactResource::class;
    protected $createRequestClass = ContactRequest::class;
    protected $updateRequestClass = ContactUpdateRequest::class;

    public function __construct(ContactService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
}
