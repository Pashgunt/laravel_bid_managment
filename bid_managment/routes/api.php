<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthToken;

Route::get('/setCookies', [ApiAuthToken::class, 'store']);