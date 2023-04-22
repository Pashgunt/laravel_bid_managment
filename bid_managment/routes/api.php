<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthToken;
use App\Http\Controllers\Api\ApiAccountActive;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\AuthTokenController;
use App\Http\Controllers\UserController;

// Route::post('/setCookies', [ApiAuthToken::class, 'store'])->name('setCookiesForAccount');
// Route::post('/makeInnactiveAccount', [ApiAccountActive::class, 'storeInnactive']);
// Route::post('/makeActiveAccount', [ApiAccountActive::class, 'storeActive']);


Route::post('/login', [LoginUserController::class, 'store']);
Route::post('/signup', [RegisterUserController::class, 'store']);

Route::middleware('auth:api')->group(function () {
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
    });
});
