<?php

use App\Http\Controllers\ApiV1\ContactController;
use App\Http\Controllers\ApiV1\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::middleware('auth.api')->group(function () {
        Route::controller(NotificationController::class)->group(function () {
            Route::get('/notifications', 'index');
            Route::get('/notifications/show/{id}', 'show');
        });

        //  Управление временем (TimeTrackingController)

        require base_path('routes/chat.php');
        require base_path('routes/crm.php');
    });
});

require_once 'auth.php';
