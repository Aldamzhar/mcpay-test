<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/roles', [RoleController::class, 'index']);

    Route::middleware('admin')->group(function () {
        Route::apiResource('users', UserController::class);
    });

    Route::get('/user', function () {
        return response()->json(auth()->user()->load('role'), 200);
    });
});
