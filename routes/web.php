<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('landing.index');
// });


Route::get('/', [\App\Http\Controllers\LandingController::class, 'index'])->name('landing.index');
Route::get('cashier', [\App\Http\Controllers\CashierController::class, 'index'])->name('cashier.index');


Route::middleware((['auth', 'customer']))->group(function (){
    Route::get('/profile', [\App\Http\Controllers\LandingController::class, 'profile'])->name('landing.profile');
    Route::post('/profile', [\App\Http\Controllers\LandingController::class, 'profileUpdate'])->name('update.profile');
    Route::get('/myorder', [\App\Http\Controllers\LandingController::class, 'order'])->name('yourorder.index');
    Route::post('/myorder', [\App\Http\Controllers\LandingController::class, 'orderStore'])->name('yourorder.update');
    Route::patch('/myorder/{id}', [\App\Http\Controllers\LandingController::class, 'orderCancel'])->name('yourorder.cancel');
    Route::get('/checking', [\App\Http\Controllers\LandingController::class, 'beforeOrder'])->name('beforeorder.index');
    
    
    
});
Route::get('/checkout/{id}', [\App\Http\Controllers\LandingController::class, 'checkout'])->name('checkout');

Route::middleware((['auth', 'admin']))->group(function (){
    Route::resource('dashboard', \App\Http\Controllers\DashboardController::class);
    Route::resource('productcategories', \App\Http\Controllers\ProductCategorieController::class);
    Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::resource('customer', \App\Http\Controllers\CustomerController::class);
    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::resource('member', \App\Http\Controllers\MemberController::class);
    Route::resource('order', \App\Http\Controllers\OrderController::class);
    Route::get('scanner', function () {return view('order.scanner');})->name('scanner');
    Route::get('/order/qrscan/{qr_token}', [\App\Http\Controllers\OrderController::class, 'qrscan'])->name('order.qrscan');
    Route::resource('payment', \App\Http\Controllers\PaymentController::class);
    Route::get('/profil', [\App\Http\Controllers\DashboardController::class, 'profile'])->name('dashboard.profil');
    Route::post('/profil/update', [\App\Http\Controllers\DashboardController::class, 'profileUpdate'])->name('update.profil');
});


Route::middleware('guest')->group(function (){
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot', [AuthController::class, 'showForgotForm'])->name('show-forgot');
    Route::post('/forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::get('/reset/{token}', function (string $token) { 
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
    Route::post('/reset', [AuthController::class, 'reset'])->name('reset');

});


// cashier
Route::middleware((['auth', 'cashier']))->group(function (){});


Route::post('/logout', [AuthController::class, 'logout'])->name('logout');







