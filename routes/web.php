<?php

use App\Http\Controllers\AuthController;

Route::view('/', 'home');

Route::get('/auth', [AuthController::class, 'index']);
Route::post('/loginseller', [AuthController::class, 'login']);
Route::post('/registerseller', [AuthController::class, 'register']);
Route::post('/loginseller', [AuthController::class, 'login']);
Route::post('/registerseller', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
