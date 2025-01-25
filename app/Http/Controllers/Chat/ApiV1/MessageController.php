<?php

namespace App\Http\Controllers\Chat\ApiV1;

use App\Http\Controllers\MainController;
use App\Http\Requests\Chat\MessageRequest;
use App\Http\Requests\Chat\MessageUpdateRequest;
use App\Http\Resources\Chat\MessagesResource;
use App\Services\Chat\MessageService;
use Illuminate\Http\Request;

class MessageController extends MainController
{
    public function index(Request $request, MessageService $service, $roomId)
    {
        return $this->executeRequest(function () use ($service, $request, $roomId) {
            return MessagesResource::collection($service->getMessagesInRoom($roomId, $request->input('paginate', 20)))->resolve();
        });
    }

    public function send(MessageRequest $request, MessageService $service)
    {
        return $this->executeRequest(function () use ($request, $service) {
            $data = $request->validated();
            return MessagesResource::make($service->send($data));
        });
    }

    /**
     * @throws \Exception
     */
    public  function update(MessageUpdateRequest $request, MessageService $service, $id)
    {
        return $this->executeRequest( function () use ($request, $service, $id) {
           $data = $request->validated();
           return $service->update($id, $data);
        });
    }

    public function show(Request $request, MessageService $service, $id)
    {
        return $this->executeRequest(function () use ($request, $service, $id) {
            return MessagesResource::make($service->show($id))->resolve();
        });
    }
    public function delete(Request $request, MessageService $service, $id)
    {
        return $this->executeRequest(function () use ($request, $service, $id) {
            $service->delete($id);
        });
    }
}
