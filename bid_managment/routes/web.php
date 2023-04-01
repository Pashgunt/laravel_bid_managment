<?php

use App\Http\Controllers\AuthTokenController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->prefix("/auth")->group(function () {
    Route::get("/", [AuthTokenController::class, "index"])->name('auth-request');
    Route::get("/list", [AuthTokenController::class, "list"])->name('auth-list-requests');
    Route::post("/", [AuthTokenController::class, "store"])->name('auth-request-send');
    Route::get('/direct', [AuthTokenController::class, "direct"])->name("auth-direct");
});
