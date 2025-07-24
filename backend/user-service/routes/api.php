<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;

Route::group(['middleware' => 'api'], function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware(['auth:api'])->prefix('token/refresh')->group(function () {
    Route::post('/', [AuthController::class, 'refresh']);
});
