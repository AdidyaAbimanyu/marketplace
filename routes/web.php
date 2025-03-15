<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenjualController;

Route::view('/', 'home')->name('home');

Route::get('/auth', [AuthController::class, 'auth'])->name('auth');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware('auth:penjual')->group(function () {
    Route::get('/penjual/dashboard', [PenjualController::class, 'dashboard'])->name('penjual.dashboard');
});

Route::middleware('auth:pembeli')->group(function () {
    
});
