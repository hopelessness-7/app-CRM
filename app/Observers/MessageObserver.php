<?php

namespace App\Observers;

use App\Models\Chat\Message;
use App\Services\Chat\CacheInvalidationService;
use Illuminate\Support\Facades\Cache;

class MessageObserver
{
    protected CacheInvalidationService $cacheInvalidationService;

    public function __construct(CacheInvalidationService $cacheInvalidationService)
    {
        $this->cacheInvalidationService = $cacheInvalidationService;
    }

    public function created(Message $message): void
    {
        $this->invalidateCache($message);
    }

    public function updated(Message $message): void
    {
        $this->invalidateCache($message);
    }

    public function saved(Message $message): void
    {
        $this->invalidateCache($message);
    }

    public function deleted(Message $message): void
    {
        $this->invalidateCache($message);
    }

    private function invalidateCache(Message $message): void
    {
        $room = $message->room;
        if (!$room || !$room->users) {
            return; // Если нет комнаты или пользователей, выходим
        }

        // Получаем room_id и пользователей, чтобы сбросить кэш
        $roomId = $room->id;
        $userIds = $room->users->pluck('id')->toArray();

        // Сбрасываем кэш для всех пользователей этой комнаты
        $this->cacheInvalidationService->invalidateCache($roomId, $userIds);
    }
}
