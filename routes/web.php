<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'showLoginForm'])->name("showLoginForm");
Route::post('/login', [AuthController::class, 'login'])->name("login");
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('registerForm');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/create', [OrderController::class, 'create'])->name('create');
Route::post('/order', [OrderController::class, 'store'])->name('store');
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('cancel');


