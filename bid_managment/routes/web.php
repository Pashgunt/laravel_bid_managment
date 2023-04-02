<?php

use App\Http\Controllers\AuthTokenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\RegisterUserController;

Route::middleware(['guest'])->prefix("/direct")->group(function () {
    Route::get("/send", [AuthTokenController::class, "index"])->name('auth-request');
    Route::post("/send", [AuthTokenController::class, "store"])->name('auth-request-send');
    Route::get("/list", [AuthTokenController::class, "list"])->name('auth-list-requests');
    Route::get('/new', [AuthTokenController::class, "direct"])->name("auth-direct");
});

Route::middleware(['guest'])->prefix('/register')->group(function () {
    Route::get('/', [RegisterUserController::class, 'index'])->name('register-page');
    Route::post('/', [RegisterUserController::class, 'store'])->name('gegister-new');
});

Route::middleware(['guest'])->prefix('/auth')->group(function () {
    Route::get('/', [LoginUserController::class, 'index'])->name('auth-page');
});
