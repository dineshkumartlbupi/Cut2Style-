<?php

use App\Http\Controllers\API\AuthController;
// use App\Http\Controllers\API\UserController;
// use App\Http\Controllers\API\BookingController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Example protected routes by role
    Route::middleware('role:Admin')->get('/admin', fn () => response()->json(['message' => 'Hello Admin']));
    Route::middleware('role:Vendor')->get('/vendor', fn () => response()->json(['message' => 'Hello Vendor']));
    Route::middleware('role:User')->get('/user', fn () => response()->json(['message' => 'Hello User']));

    // Route::get('/bookings', [BookingController::class, 'index']);
    // Route::post('/bookings', [BookingController::class, 'store']);
});
