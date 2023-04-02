<?php

use App\Http\Controllers\AuthTokenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\RecoveryController;

Route::middleware(['guest'])->group(function () {
    Route::prefix('/register')->group(function () {
        Route::get('/', [RegisterUserController::class, 'index'])->name('register-page');
        Route::post('/', [RegisterUserController::class, 'store'])->name('register-new');
    });
    Route::prefix('/auth')->group(function () {
        Route::get('/', [LoginUserController::class, 'index'])->name('auth-page');
        Route::post('/', [LoginUserController::class, 'store'])->name('auth-send');
    });
    Route::prefix('/recovery')->group(function () {
        Route::get('/', [RecoveryController::class, 'index'])->name('recovery-page');
        Route::get('/{recovery_token}', [RecoveryController::class, 'checkRecoveryToken'])->name('recovery-token');
        Route::post('/', [RecoveryController::class, 'store'])->name('recovery-send-request');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('/direct')->group(function () {
        Route::get("/send", [AuthTokenController::class, "index"])->name('auth-request');
        Route::post("/send", [AuthTokenController::class, "store"])->name('auth-request-send');
        Route::get("/list", [AuthTokenController::class, "list"])->name('auth-list-requests');
        Route::get('/new', [AuthTokenController::class, "direct"])->name("auth-direct");
    });
    Route::get('/logout', [LoginUserController::class, 'logout'])->name('auth-logout');
});
