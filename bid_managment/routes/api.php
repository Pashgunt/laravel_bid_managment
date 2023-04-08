<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthToken;
use App\Http\Controllers\Api\ApiAccountActive;


Route::post('/setCookies', [ApiAuthToken::class, 'store']);
Route::post('/makeInnactiveAccount', [ApiAccountActive::class, 'storeInnactive']);
Route::post('/makeActiveAccount', [ApiAccountActive::class, 'storeActive']);
