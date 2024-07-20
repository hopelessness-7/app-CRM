<?php

use App\Http\Controllers\ApiV1\Kanban\DashboardController;
use App\Http\Controllers\ApiV1\Kanban\TeamController;
use Illuminate\Support\Facades\Route;

Route::prefix('kanban')->group(function () {
    Route::middleware('auth.api')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboards', 'index');
            Route::get('/dashboards/show/{id}', 'show');
            Route::post('/dashboards/create', 'store');
            Route::post('/dashboards/update/{id}', 'update');
            Route::delete('dashboards/delete/{id}', 'delete');
        });

        Route::controller(TeamController::class)->group(function () {
            Route::get('/teams', 'index');
            Route::get('/teams/show/{id}', 'show');
            Route::post('/teams/create', 'store');
            Route::post('/teams/update/{id}', 'update');
            Route::delete('teams/delete/{id}', 'delete');
        });
    });
});
