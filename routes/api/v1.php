<?php

use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::name('auth.')->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('register');
    });
    Route::middleware(['auth'])->group(function () {
        Route::post('register/admin', [AuthController::class, 'registerAdmin'])->name('auth.register.admin');
    });
});
