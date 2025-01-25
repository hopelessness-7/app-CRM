<?php

use App\Http\Controllers\ApiV1\Auth\ConfirmationCodeController;
use App\Http\Controllers\ApiV1\Auth\LoginController;
use App\Http\Controllers\ApiV1\Auth\RegisterController;
use App\Http\Controllers\ApiV1\Auth\UserController;
use App\Http\Controllers\ApiV1\Auth\VerificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.api')->group(function () {
    Route::get('/profile/{id?}', [UserController::class, 'show']);
    Route::get('/search/user', [UserController::class, 'search']);
    Route::post('/profile/update', [UserController::class, 'update']);
});

Route::post('/login', [LoginController::class, '__invoke'])->name('login');
Route::post('/register', [RegisterController::class, '__invoke']);
Route::post('/new_confirmation_code', [ConfirmationCodeController::class, 'newConfirmationCode']);
Route::post('/confirmation_code', [ConfirmationCodeController::class, 'confirmationCode']);

// Verify notice email
Route::get('/email/verify',  [VerificationController::class, 'notice'])->name('verification.notice');
// Verify email
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
// Resend link to verify email
Route::post('/email/verify/resend', [VerificationController::class, 'resend'])->name('verification.send');
