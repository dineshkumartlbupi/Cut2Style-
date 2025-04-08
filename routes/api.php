<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BookingController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [UserController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::get('/bookings', [BookingController::class, 'index']);
    // Route::post('/bookings', [BookingController::class, 'store']);
});
