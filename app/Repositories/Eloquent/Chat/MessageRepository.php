<?php

namespace App\Repositories\Eloquent\Chat;

use App\Models\Chat\Message;
use App\Repositories\Eloquent\RepositoryBase;
use Illuminate\Pagination\LengthAwarePaginator;

class MessageRepository extends RepositoryBase
{
    public function __construct(Message $message)
    {
        parent::__construct($message);
    }

    public function getMessagesInRoom($roomId, $user, $paginate): LengthAwarePaginator
    {
        return app(RoomRepository::class)->getMessagesInRoom($roomId, $user, $paginate);
    }

    public function update($id, $data): bool
    {
        $user = auth()->user();
        $message = $this->select(['id', 'user_id'])->where('user_id', $user->id)->where('id', $id)->firstQuery();

        if (!$message) {
            throw new \Exception('item not found', 404);
        }

        return $message->update($data);
    }
}
