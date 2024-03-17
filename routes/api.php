<?php

use App\Http\Controllers\ApiV1\Auth\ConfirmationCodeController;
use App\Http\Controllers\ApiV1\Auth\LoginController;
use App\Http\Controllers\ApiV1\Auth\RegisterController;
use App\Http\Controllers\ApiV1\Auth\UserController;
use App\Http\Controllers\ApiV1\Auth\VerificationController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.api')->group(function () {
    Route::get('/profile/{id?}', [UserController::class, 'index']);
    Route::get('/search/user', [UserController::class, 'search']);
    Route::post('/profile/update', [UserController::class, 'update']);
});

Route::post('/login', [LoginController::class, '__invoke']);
Route::post('/register', [RegisterController::class, '__invoke']);
Route::post('/new_confirmation_code', [ConfirmationCodeController::class, 'newConfirmationCode']);
Route::post('/confirmation_code', [ConfirmationCodeController::class, 'confirmationCode']);



// Verify email
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['throttle:6,1'])->name('verification.verify');
// Resend link to verify email
Route::post('/email/verify/resend', [VerificationController::class, 'resend'])->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');
