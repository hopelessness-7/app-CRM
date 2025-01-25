<?php

namespace App\Repositories\Eloquent\Chat;

use App\Models\Chat\Room;
use App\Repositories\Eloquent\RepositoryBase;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class RoomRepository extends RepositoryBase
{
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }

    public function update($id, $data): Model
    {
        $user = auth()->user();
        $room = $this->model->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->find($id);

        if (!$room) {
            throw new \Exception('item not found', 404);
        }

        $room->update($data);
        return $room;
    }

    public function getMessagesInRoom($roomId, $user, $paginate): LengthAwarePaginator
    {
        // Создаем уникальный ключ для кэша
        $cacheKey = "room_{$roomId}_user_{$user->id}_paginate_{$paginate}";
        // Добавляем теги для группировки ключей
        $cacheTags = ["room_{$roomId}_messages", "user_{$user->id}_messages"];

        // Проверяем наличие данных в кэше
        return Cache::tags($cacheTags)->remember($cacheKey, now()->addMinutes(10), function () use ($roomId, $user, $paginate) {
            $room = $this->model->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->where('id', $roomId)->first();

            return $room ? $room->messages()->paginate($paginate) : collect();
        });
    }
}
