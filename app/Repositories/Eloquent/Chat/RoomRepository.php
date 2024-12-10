<?php

namespace App\Repositories\Eloquent\Chat;

use App\Models\Chat\Room;
use App\Repositories\Eloquent\RepositoryBase;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoomRepository extends RepositoryBase
{
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }

    public function update($id, $data): bool
    {
        $user = auth()->user();
        $room = $this->model->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->find($id);

        if (!$room) {
            throw new \Exception('item not found', 404);
        }

        return $room->update($data);
    }

    public function getMessagesInRoom($roomId, $user, $paginate): LengthAwarePaginator
    {
        $room = $this->model->whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->where('id', $roomId)->first();

        return $room ? $room->messages()->paginate($paginate) : collect();
    }

}
