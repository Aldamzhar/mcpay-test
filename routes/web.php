<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth', EnsureUserHasRole::class.':Администратор'])->group(function () {
    Route::get('/admin', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::resource('users', UserController::class)->except(['show']);
});

Route::middleware(['auth', EnsureUserHasRole::class.':Пользователь'])->group(function () {
    Route::get('/user', [UserController::class, 'user'])->name('user.dashboard');
});
