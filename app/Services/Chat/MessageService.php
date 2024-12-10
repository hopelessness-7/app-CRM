<?php

namespace App\Services\Chat;

use App\Models\Chat\Message;
use App\Models\Chat\Room;
use App\Repositories\Eloquent\Chat\MessageRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class MessageService
{
    protected MessageRepository $repository;
    protected Model $user;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
        $this->user = auth()->user();
    }

    public function getMessagesInRoom($roomId, $paginate): LengthAwarePaginator
    {
        $user = $this->user;
        return $this->repository->getMessagesInRoom($roomId, $user, $paginate);
    }

    public function send($data): Model
    {
        return $this->repository->create($data);
    }

    public function show($messageId): Model
    {
        return $this->repository->find($messageId);
    }

    /**
     * @throws \Exception
     */
    public function update($messageId, $data): Model
    {
        $this->repository->update($messageId, $data);
        return $this->show($messageId);
    }

    public function delete($messageId): void
    {
        $this->repository->delete($messageId);
    }
}
