<?php

namespace App\Http\Controllers\ApiV1\Chat;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Chat\MessageRequest;
use App\Http\Requests\Chat\MessageUpdateRequest;
use App\Http\Resources\Chat\MessagesResource;
use App\Services\Chat\MessageService;
use Illuminate\Http\Request;

class MessageController extends BaseController
{
    protected $service;
    protected $resourceClass = MessagesResource::class;
    protected $createRequestClass = MessageRequest::class;
    protected $updateRequestClass = MessageUpdateRequest::class;

    public function __construct(MessageService $service)
    {
        parent::__construct($service);
        $this->service = $service;
    }
}
