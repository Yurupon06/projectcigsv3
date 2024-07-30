<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('landing.index');
// });

// In routes/web.php
Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing.index');


Route::resource('dashboard', \App\Http\Controllers\DashboardController::class);
Route::resource('productcategories', \App\Http\Controllers\ProductCategorieController::class);
Route::resource('product', \App\Http\Controllers\ProductController::class);
Route::resource('customer', \App\Http\Controllers\CustomerController::class);
Route::resource('user', \App\Http\Controllers\UserController::class);
Route::resource('member', \App\Http\Controllers\MemberController::class);
Route::resource('order', \App\Http\Controllers\OrderController::class);
Route::resource('payment', \App\Http\Controllers\PaymentController::class);