<?php

use App\Http\Controllers\ActiveAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAccountActive;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\AuthTokenController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\RecoveryController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

Route::fallback(function () {
    return response('NOT FOUND', 404);
});

Route::get('/captcha', CaptchaController::class);

Route::middleware(['guest:api'])->group(function () {
    Route::post('/login', [LoginUserController::class, 'store'])->name('login');
    Route::post('/signup', [RegisterUserController::class, 'store'])->name('signup');
    Route::prefix('/recovery')->group(function () {
        Route::get('/{token}', [RecoveryController::class, 'checkRecoveryToken'])->name('recovery-token');
        Route::patch('/{token}', [RecoveryController::class, 'makeInnactive'])->name('make-inactive-token');
        Route::post('/new/{token}', [RecoveryController::class, 'createNewPass'])->name('recovery-send-change');
        Route::post('/', [RecoveryController::class, 'store'])->name('recovery-send-request');
    });
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('verify/resend', [TwoFactorController::class, 'resend'])->name('verify.resend');
    Route::resource('verify', TwoFactorController::class)
        ->only(['index', 'store'])
        ->missing(function (Request $request) {
            return Redirect::route('login');
        });
});

Route::middleware(['auth:api', 'twofactor:api'])->group(function () {
    Route::post('/logout', [LoginUserController::class, 'logout'])->name('logout');

    Route::resource('user', UserController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->missing(function (Request $request) {
            return Redirect::route('getAllAccount');
        });

    Route::resource('account', AuthTokenController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->missing(function (Request $request) {
            return Redirect::route('getAllAccount');
        });

    Route::prefix('/account')->group(function () {
        Route::post('/delete_cancel', [AuthTokenController::class, 'deleteCancel'])->name('cancelDeleteAccount');
        Route::post('/get_access_token', [AuthTokenController::class, 'direct'])->name('getAccessToken');
        Route::post('/make_inactive', [ApiAccountActive::class, 'storeInnactive'])->name('makeInnactiveAccount');
        Route::post('/make_active', [ApiAccountActive::class, 'storeActive'])->name('makeActiveAccount');

        Route::prefix('/information/{id}')->group(function () {
            Route::get('/', [ActiveAccountController::class, 'index'])->name('accountDataInfo');
            Route::get('/campaigns', [ActiveAccountController::class, 'getCampaigns'])->name('accountInfoCampaign');
            Route::get('/adgroups', [ActiveAccountController::class, 'getAdGroups'])->name('accountInfoAdGroup');
            Route::get('/keywords', [ActiveAccountController::class, 'getKeywords'])->name('accountInfoKeyword');
        });
    });
});
