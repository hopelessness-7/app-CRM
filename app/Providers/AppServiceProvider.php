<?php

namespace App\Providers;

use App\Models\Chat\Message;
use App\Models\Chat\Room;
use App\Observers\MessageObserver;
use App\Observers\RoomObserver;
use App\Services\Chat\CacheInvalidationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CacheInvalidationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Message::observe(MessageObserver::class);
        Room::observe(RoomObserver::class);
    }
}
