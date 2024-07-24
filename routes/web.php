<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('dashboard', \App\Http\Controllers\DashboardController::class);
Route::resource('productcategories', \App\Http\Controllers\ProductCategorieController::class);