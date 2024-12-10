<?php

use App\Http\Controllers\Chat\ApiV1\MessageController;
use Illuminate\Support\Facades\Route;

Route::prefix('chat')->group(function () {
    Route::middleware('auth.api')->group(function () {
        Route::controller(MessageController::class)->group(function () {
            Route::get('/{roomId}/messages', 'index');
        });

    });
});
