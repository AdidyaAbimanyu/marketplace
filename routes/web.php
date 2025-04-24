<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PembeliController::class, 'home'])->name('home');

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

Route::get('/products', [PembeliController::class, 'products'])->name('pembeli.products');
Route::get('/products/{id}', [PembeliController::class, 'productDetail'])->name('pembeli.product');

Route::middleware('role:pembeli')->group(function () {
    Route::get('/cart', [PembeliController::class, 'cart'])->name('pembeli.cart');
    Route::post('/cart/add', [PembeliController::class, 'addToCart'])->name('pembeli.addToCart');
    Route::get('/checkout', [PembeliController::class, 'checkout'])->name('pembeli.checkout');
    Route::post('/checkout-process', [PembeliController::class, 'checkoutProcess'])->name('pembeli.checkout-process');
    Route::get('/review/{id}', [PembeliController::class, 'formReview'])->name('pembeli.review');
    Route::post('/review/submit', [PembeliController::class, 'submitReview'])->name('pembeli.history-order');
    Route::post('/review/{id}', [PembeliController::class, 'storeReview'])->name('review.submit');
    Route::get('/order-tracking/{id}', [PembeliController::class, 'orderTracking'])->name('pembeli.order-tracking');
    Route::post('/payment-process', [PembeliController::class, 'paymentProcess'])->name('pembeli.payment-process');
    Route::get('/history-order', [PembeliController::class, 'historyOrder'])->name('pembeli.history-order');
});