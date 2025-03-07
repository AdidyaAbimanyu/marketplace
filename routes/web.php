<?php

use App\Http\Controllers\AuthController;

Route::view('/', 'home');

Route::get('/auth', [AuthController::class, 'index'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return "Selamat datang di Dashboard!";
})->middleware('auth')->name('dashboard');
