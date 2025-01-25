<?php

use App\Http\Controllers\Chat\ApiV1\MessageController;
use App\Http\Controllers\Chat\ApiV1\RoomController;
use Illuminate\Support\Facades\Route;

Route::prefix('chat')->group(function () {
    Route::middleware('auth.api')->group(function () {
        Route::controller(MessageController::class)->group(function () {
            Route::get('/{roomId}/messages', 'index');
            Route::get('/messages/show/{id}', 'show');
            Route::post('/messages/send', 'send');
            Route::put('/messages/update/{id}', 'update');
            Route::delete('/messages/delete/{id}', 'delete');
        });
        Route::controller(RoomController::class)->group(function () {
            Route::get('/rooms', 'index');
            Route::get('/rooms/show/{id}', 'show');
            Route::post('/rooms/create', 'create');
            Route::put('/rooms/update/{id}', 'update');
            Route::delete('/rooms/delete/{id}', 'delete');
        });
    });
});
