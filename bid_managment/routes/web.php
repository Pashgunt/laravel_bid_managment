<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecoveryController;

Route::middleware(['guest'])->group(function () {

    Route::prefix('/recovery')->group(function () {
        Route::get('/', [RecoveryController::class, 'index'])->name('recovery-page');
        Route::post('/', [RecoveryController::class, 'store'])->name('recovery-send-request');
        Route::get('/{recovery_token}', [RecoveryController::class, 'checkRecoveryToken'])->name('recovery-token');
        Route::post('/new', [RecoveryController::class, 'createNewPass'])->name('recovery-send-change');
        Route::get('/new/{token}', [RecoveryController::class, 'changePasswordForm'])->name('recovery-change');
    });
});
