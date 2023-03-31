<?php

use App\Http\Controllers\AuthTokenController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->prefix("/auth")->group(function () {
    Route::get('/direct', [AuthTokenController::class, "direct"])->name("auth.direct");
});
