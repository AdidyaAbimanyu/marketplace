<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\ProdukController;

Route::get('/', [PembeliController::class, 'index'])->name('home');

Route::get('/auth', [AuthController::class, 'auth'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/search', [ProdukController::class, 'search'])->name('search');
Route::get('/produk/{id}', [ProdukController::class, 'detail'])->name('detail');

Route::middleware('auth')->group(function () {
    Route::get('/cart', [ProdukController::class, 'cart'])->name('cart.index');
    Route::get('/cart/update/{id}/{aksi}', [ProdukController::class, 'updateJumlah'])->name('cart.updateJumlah');
    Route::post('/cart/add', [ProdukController::class, 'add'])->name('cart.add');
    Route::post('/buynow', [ProdukController::class, 'buynow'])->name('buynow');
    Route::delete('/cart/{cart}', [ProdukController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/checkout', [ProdukController::class, 'checkout'])->name('cart.checkout');
    Route::post('/payment-process', [ProdukController::class, 'fakePayment'])->name('pembeli.payment-process');
    Route::get('/history-order', [ProdukController::class, 'historyOrder'])->name('pembeli.history-order');
    Route::get('/order-tracking/{id}', [ProdukController::class, 'orderTracking'])->name('pembeli.order-tracking');
    Route::post('/orders/confirm/{id}', [ProdukController::class, 'confirm'])->name('orders.confirm');
    Route::get('/review/{id}', [ProdukController::class, 'formReview'])->name('review');
    Route::post('/submit-review', [ProdukController::class, 'submitReview'])->name('submit.review');
    Route::get('/checkout', [ProdukController::class, 'checkout'])->name('cart.checkout');
});

Route::middleware('role:penjual')->group(function () {
    Route::get('/penjual', [PenjualController::class, 'dashboard'])->name('penjual.dashboard');
    Route::get('/penjual/produk/create', [PenjualController::class, 'add'])->name('penjual.add');
    Route::post('/penjual/produk/store', [PenjualController::class, 'store'])->name('penjual.store');
    Route::get('/penjual/produk/edit/{id}', [PenjualController::class, 'edit'])->name('penjual.edit');
    Route::put('/penjual/produk/update/{id}', [PenjualController::class, 'update'])->name('penjual.update');
    Route::delete('/penjual/produk/delete/{id}', [PenjualController::class, 'destroy'])->name('penjual.delete');
});

Route::middleware('role:admin')->group(function () {
    Route::post('/approvement/approve/{id}', [AdministratorController::class, 'approve'])->name('approve.order');
    Route::get('/admin', [AdministratorController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/pengguna/create', [AdministratorController::class, 'add'])->name('admin.add');
    Route::post('/admin/pengguna/store', [AdministratorController::class, 'store'])->name('admin.store');
    Route::get('/admin/pengguna/edit/{id}', [AdministratorController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/pengguna/update/{id}', [AdministratorController::class, 'update'])->name('admin.update');
    Route::post('/admin/reset/{id}', [AdministratorController::class, 'reset'])->name('admin.reset');
    Route::delete('/admin/pengguna/delete/{id}', [AdministratorController::class, 'destroy'])->name('admin.delete');
});
