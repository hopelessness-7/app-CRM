<?php

use App\Http\Controllers\ApiV1\Chat\MessageController;
use App\Http\Controllers\ApiV1\Chat\RoomController;
use Illuminate\Support\Facades\Route;

Route::prefix('chat')->group(function () {
    Route::controller(MessageController::class)->group(function () {
        Route::get('/{roomId}/messages', 'index');
        Route::get('/messages/show/{id}', 'show');
        Route::post('/messages/send', 'create');
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
