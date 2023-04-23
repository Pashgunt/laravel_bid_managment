<?php

use App\Http\Controllers\ActiveAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAccountActive;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\AuthTokenController;
use App\Http\Controllers\UserController;

Route::middleware(['guest:api'])->group(function () {
    Route::post('/login', [LoginUserController::class, 'store'])->name('login');
    Route::post('/signup', [RegisterUserController::class, 'store'])->name('signup');
});

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/current', [UserController::class, 'getCurrentUser'])->name('getCurrentUser');
        Route::post('/logout', [LoginUserController::class, 'logout'])->name('logoutUser');
    });

    Route::prefix('/account')->group(function () {
        Route::get('/list', [AuthTokenController::class, 'list'])->name('getAllAccount');
        Route::post('/new', [AuthTokenController::class, 'store'])->name('createNewAccount');
        Route::post('/delete', [AuthTokenController::class, 'delete'])->name('deleteAccount');
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
