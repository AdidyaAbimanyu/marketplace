<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenjualController;

Route::view('/', 'home')->name('home');

Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdministratorController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/penjual', [PenjualController::class, 'dashboard'])->name('penjual.dashboard');
});
