<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::post('auth/register', [RegisterController::class, 'register'])->name('auth.register');
Route::get('auth/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// user login
Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // user logout
    Route::get('/logout', [LogoutController::class, 'logout']);
    // user
    Route::get("/user", [UserController::class, "user"]);
});

