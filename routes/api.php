<?php

use App\Http\Controllers\ApiV1\ContactController;
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
        Route::controller(ContactController::class)->group(function () {
            Route::get('/contacts', 'index');
            Route::get('/contacts/show/{id}', 'show');
            Route::post('/contacts/create', 'create');
            Route::post('/contacts/update/{id}', 'update');
            Route::delete('contacts/delete/{id}', 'delete');
        });
    });

    require_once 'kanban.php';
    require_once 'chat.php';
});

require_once 'auth.php';
