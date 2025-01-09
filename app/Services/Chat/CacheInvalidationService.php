<?php

namespace App\Services\Chat;

use Illuminate\Support\Facades\Cache;

class CacheInvalidationService
{
    /**
     * Reset cache for all users in the room
     *
     * @param int $roomId
     * @param array $userIds
     */
    public function invalidateCache(int $roomId, array $userIds): void
    {
        $tagRoomCache = "room_{$roomId}_messages";
        $this->clearCacheByTag($tagRoomCache);

        // Reset the cache for all users of this room
        foreach ($userIds as $id) {
            $tagUserCache = "user_{$id}_messages";
            $this->clearCacheByTag($tagUserCache);
        }
    }

    /**
     * Deleting cache by tag
     *
     * @param string $tag
     */
    private function clearCacheByTag(string $tag): void
    {
        if (Cache::getDefaultDriver() !== 'redis') {
            throw new \RuntimeException('The method only supports Redis as a cache driver');
        }

        // Deleting a cache with a specific tag
        Cache::tags([$tag])->flush();
    }
}

