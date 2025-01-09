<?php

namespace App\Observers;

use App\Models\Chat\Room;
use App\Services\Chat\CacheInvalidationService;

class RoomObserver
{
    protected CacheInvalidationService $cacheInvalidationService;

    public function __construct(CacheInvalidationService $cacheInvalidationService)
    {
        $this->cacheInvalidationService = $cacheInvalidationService;
    }

    public function created(Room $room): void
    {
        $this->invalidateCache($room);
    }

    public function updated(Room $room): void
    {
        $this->invalidateCache($room);
    }

    public function saved(Room $room): void
    {
        $this->invalidateCache($room);
    }

    public function deleted(Room $room): void
    {
        $this->invalidateCache($room);
    }

    private function invalidateCache(Room $room): void
    {
        $roomId = $room->id;
        $userIds = $room->users->pluck('id')->toArray();

        // Сбрасываем кэш для всех пользователей этой комнаты
        $this->cacheInvalidationService->invalidateCache($roomId, $userIds);
    }
}
