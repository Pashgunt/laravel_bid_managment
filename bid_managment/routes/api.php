<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthToken;
use App\Http\Controllers\Api\ApiAccountActive;
use App\Http\Controllers\Auth\LoginUserController;


Route::post('/setCookies', [ApiAuthToken::class, 'store']);
Route::post('/makeInnactiveAccount', [ApiAccountActive::class, 'storeInnactive']);
Route::post('/makeActiveAccount', [ApiAccountActive::class, 'storeActive']);


Route::post('/auth', [LoginUserController::class, 'store']);
