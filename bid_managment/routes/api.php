<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthToken;
use App\Http\Controllers\Api\ApiAccountActive;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;

Route::post('/setCookies', [ApiAuthToken::class, 'store']);
Route::post('/makeInnactiveAccount', [ApiAccountActive::class, 'storeInnactive']);
Route::post('/makeActiveAccount', [ApiAccountActive::class, 'storeActive']);


Route::post('/login', [LoginUserController::class, 'store']);
Route::post('/signup', [RegisterUserController::class, 'store']);

Route::middleware('auth:api')->group(function(){
    Route::post('/logout');
});