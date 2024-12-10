<?php

namespace App\Http\Controllers\Chat\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Resources\Chat\MessagesResource;
use App\Services\Chat\MessageService;
use Illuminate\Http\Request;

class MessageController extends MainController
{
    public function index(Request $request, MessageService $service, $roomId)
    {
        return $this->handleRequest(function () use ($service, $request, $roomId) {
            return MessagesResource::collection($service->getMessagesInRoom($roomId, $request->input('paginate', 20)))->resolve();
        });
    }
}