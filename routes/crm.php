<?php

use App\Http\Controllers\ApiV1\Client\ClientController;
use App\Http\Controllers\ApiV1\Client\FilterClientController;
use App\Http\Controllers\ApiV1\Client\SearchClientController;
use App\Http\Controllers\ApiV1\ContactController;
use App\Http\Controllers\ApiV1\ContactInformationController;
use App\Http\Controllers\ApiV1\DealController;
use App\Http\Controllers\ApiV1\SchedulerController;
use App\Http\Controllers\ApiV1\WorkerController;
use App\Http\Controllers\Kanban\ApiV1\ClientTaskController;
use App\Http\Controllers\Kanban\ApiV1\DashboardController;
use App\Http\Controllers\Kanban\ApiV1\TaskController;
use App\Http\Controllers\Kanban\ApiV1\TeamController;
use Illuminate\Support\Facades\Route;

Route::prefix('/crm')->group(function () {
    Route::prefix('/kanban')->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/dashboards', 'index');
            Route::get('/dashboards/show/{id}', 'show')->name('dashboards.show');
            Route::post('/dashboards/create', 'store');
            Route::put('/dashboards/update/{id}', 'update');
            Route::delete('/dashboards/delete/{id}', 'destroy');
        });
        Route::controller(TeamController::class)->group(function () {
            Route::get('/teams', 'index');
            Route::get('/teams/show/{id}', 'show');
            Route::post('/teams/create', 'store');
            Route::put('/teams/update/{id}', 'update');
            Route::delete('/teams/delete/{id}', 'destroy');
        });
        Route::controller(TaskController::class)->group(function () {
            Route::get('/tasks/{dashboardId}', 'index');
            Route::get('/tasks/show/{id}', 'show');
            Route::post('/tasks/create', 'create');
            Route::put('/tasks/update/{id}', 'update');
            Route::delete('/tasks/delete/{id}', 'delete');
        });
        Route::controller(ClientTaskController::class)->group(function () {
            Route::post('/tasks/clients/set', 'setClientFromTask');
            Route::post('/tasks/clients/delete', 'deleteClientFromTask');
        });
    });
    Route::controller(ContactController::class)->group(function () {
        Route::get('/contacts', 'index');
        Route::get('/contacts/show/{id}', 'show');
        Route::post('/contacts/create', 'create');
        Route::put('/contacts/update/{id}', 'update');
        Route::delete('/contacts/delete/{id}', 'delete');
    });
    Route::controller(ContactInformationController::class)->group(function () {
        Route::get('/communications/types', 'getCommunicationType');
        Route::post('/contacts/information/set', 'set');
        Route::put('/contacts/information/update/{id}', 'update');
        Route::delete('/contacts/information/delete/{id}', 'delete');
    });
    Route::controller(WorkerController::class)->group(function () {
        Route::get('/workers', 'index');
        Route::get('/workers/show/{id}', 'show');
        Route::post('/workers/create', 'create');
        Route::put('/workers/update/{id}', 'update');
        Route::delete('/workers/delete/{id}', 'delete');
    });
    Route::prefix('clients')->group(function () {
        Route::controller(ClientController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/show/{id}', 'show');
            Route::post('/create', 'create');
            Route::put('/update/{id}', 'update');
            Route::delete('/delete/{id}', 'delete');
        });
        Route::get('/filter', [FilterClientController::class, 'index']);
        Route::get('/search', [SearchClientController::class, 'index']);
    });
    Route::controller(DealController::class)->group(function () {
        Route::get('/deals/workers/{id}', 'getFromWorker');
        Route::get('/deals/clients/{id}', 'getFromClient');
        Route::get('/deals', 'index');
        Route::get('/deals/show/{id}', 'show');
        Route::post('/deals/create', 'store');
        Route::put('/deals/update/{id}', 'update');
        Route::delete('/deals/delete/{id}', 'destroy');
    });
    Route::controller(SchedulerController::class)->group(function () {
        Route::get('/schedulers', 'index');
        Route::get('/schedulers/show/{id}', 'show');
        Route::post('/schedulers/create', 'store');
        Route::put('/schedulers/update/{id}', 'update');
        Route::delete('/schedulers/delete/{id}', 'destroy');
    });

    // Воронка продаж (Sales Pipeline) - SalesPipelineController
    // Аналитика и отчеты - ReportController
    // шаблоны - автоматизация стандартных задач - AutomationController
    // Управление договоренностями и документами - DocumentController

    // Геймификация (GamificationController)
    //  Управление возвратами и жалобами (ComplaintController)
    // Управление лояльностью (LoyaltyController)
    // Управление репутацией (ReputationController)
});


