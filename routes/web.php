<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenjualController;

Route::view('/', 'home')->name('home');

Route::get('/auth', [AuthController::class, 'auth'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('role:penjual')->group(function () {
    Route::get('/penjual', [PenjualController::class, 'dashboard'])->name('penjual.dashboard');
    Route::get('/penjual/produk/create', [PenjualController::class, 'add'])->name('penjual.add');
    Route::post('/penjual/produk/store', [PenjualController::class, 'store'])->name('penjual.store');
    Route::get('/penjual/produk/edit/{id}', [PenjualController::class, 'edit'])->name('penjual.edit');
    Route::put('/penjual/produk/update/{id}', [PenjualController::class, 'update'])->name('penjual.update');
    Route::delete('/penjual/produk/delete/{id}', [PenjualController::class, 'destroy'])->name('penjual.delete');
});

Route::middleware('role:admin')->group(function () {
    Route::get('/admin', [AdministratorController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/pengguna/create', [AdministratorController::class, 'add'])->name('admin.add');
    Route::post('/admin/pengguna/store', [AdministratorController::class, 'store'])->name('admin.store');
    Route::get('/admin/pengguna/edit/{id}', [AdministratorController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/pengguna/update/{id}', [AdministratorController::class, 'update'])->name('admin.update');
    Route::post('/admin/reset/{id}', [AdministratorController::class, 'reset'])->name('admin.reset');
    Route::delete('/admin/pengguna/delete/{id}', [AdministratorController::class, 'destroy'])->name('admin.delete');
});
