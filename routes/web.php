<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberCheckinController;
use App\Http\Controllers\ProductCategorieController;
use App\Http\Controllers\ApplicationSettingController;
use App\Http\Controllers\ComplementController;


// Public
Route::get('/', [LandingController::class, 'index'])->name('landing.index');

// Auth
Route::middleware('auth')->group(function () {
    // Customer
    Route::middleware('customer')->group(function () {
        Route::prefix('/profile')->group(function () {
            Route::get('/', [LandingController::class, 'profile'])->name('landing.profile');
            Route::post('/', [LandingController::class, 'profileUpdate'])->name('update.profile');
            Route::post('/password', [LandingController::class, 'updatePassword'])->name('update.password');
        });

        Route::prefix('/myorder')->group(function () {
            Route::get('/', [LandingController::class, 'order'])->name('yourorder.index');
            Route::post('/', [LandingController::class, 'orderStore'])->name('yourorder.update');
            Route::patch('/{id}', [LandingController::class, 'orderCancel'])->name('yourorder.cancel');
        });

        Route::get('/checking', [LandingController::class, 'beforeOrder'])->name('beforeorder.index');
        Route::get('/checkout/{id}', [LandingController::class, 'checkout'])->name('checkout');
        Route::get('/membership/{id}', [LandingController::class, 'membership'])->name('customer.membership');
        Route::get('/history', [LandingController::class, 'history'])->name('landing.history');
        Route::get('/f&b', [LandingController::class, 'complement'])->name('f&b.index');
        Route::get('/f&b/{id}', [LandingController::class, 'complementDetail'])->name('f&b.detail');
    });

    // Admin
    Route::middleware('admin')->group(function () {
        Route::resource('dashboard', DashboardController::class);
        Route::resource('productcategories', ProductCategorieController::class);
        Route::resource('product', ProductController::class);
        Route::resource('customer', CustomerController::class);
        Route::resource('user', UserController::class);
        Route::resource('member', MemberController::class);
        Route::resource('order', OrderController::class);
        Route::resource('payment', PaymentController::class);
        Route::resource('complement', ComplementController::class);
        Route::view('scanner', 'order.scanner')->name('scanner');
        Route::get('/order/qrscan/{qr_token}', [OrderController::class, 'qrscan'])->name('order.qrscan');

        Route::prefix('/admin')->group(function () {
            Route::get('/profil', [DashboardController::class, 'profile'])->name('dashboard.profil');
            Route::post('/profile', [DashboardController::class, 'profileUpdate'])->name('update.profile.admin');
            Route::post('/profile/password', [DashboardController::class, 'updatePassword'])->name('update.password.admin');
        });

        Route::resource('application-setting', ApplicationSettingController::class);
    });

    // Cashier
    Route::middleware('cashier')->group(function () {
        Route::prefix('/cashier')->group(function () {
            Route::get('/', [CashierController::class, 'index'])->name('cashier.index');
            Route::get('/show', [CashierController::class, 'show'])->name('cashier.show');
            Route::get('/profile', [CashierController::class, 'profile'])->name('cashier.profile');
            Route::view('/scanner', 'cashier.scanner')->name('scanner.cashier');
            Route::get('/qrscan/{qr_token}', [CashierController::class, 'qrscan'])->name('cashier.qrscan');
            Route::get('/payment', [CashierController::class, 'payment'])->name('cashier.payment');
            Route::get('/membercheckin', [CashierController::class, 'membercheckin'])->name('cashier.membercheckin');
            Route::view('/qrcheckin', 'cashier.qrcheckin')->name('qrcheckin.cashier');
            Route::get('/qrcheckin/{qr_token}', [MemberCheckinController::class, 'qrcheckin'])->name('cashier.qrcheckin');
            Route::get('/checkin-scanner', [CashierController::class, 'qrscanner'])->name('cashier.checkin');
            Route::get('/order', [CashierController::class, 'order'])->name('cashier.order');
            Route::get('/profill', [CashierController::class, 'profile'])->name('cashier.profill');
            Route::post('/profile', [CashierController::class, 'profileUpdate'])->name('update.profile.cashier');
            Route::post('/profile/password', [CashierController::class, 'updatePassword'])->name('update.password.cashier');
            Route::post('/makeorder', [CashierController::class, 'makeOrder'])->name('make.order');
            Route::get('/receipt/{paymentId}', [CashierController::class, 'struk'])->name('cashier.receipt');
            Route::get('/member/{id}', [CashierController::class, 'detailMember'])->name('cashier.member');
            Route::post('/member/action/{id}', [CashierController::class, 'actionMember'])->name('action.member');
        });

        Route::post('/payments/{order}', [CashierController::class, 'store'])->name('payments.store');
        Route::get('/struk-gym/{id}', [CashierController::class, 'showStruk'])->name('struk_gym');
        Route::post('/customer/store', [CashierController::class, 'storeCustomer'])->name('customer.store');
        Route::get('/membercash/membercashier', [CashierController::class, 'membercashier'])->name('membercashier.membercash');
        Route::resource('members', MemberController::class);
        Route::get('/member-details/{qr_token}', [CashierController::class, 'getMemberDetails']);
        Route::post('/store-checkin', [CashierController::class, 'storeCheckIn']);
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



// Route::middleware((['auth', 'admin']))->group(function (){
//     Route::resource('dashboard', DashboardController::class);
//     Route::resource('productcategories', ProductCategorieController::class);
//     Route::resource('product', ProductController::class);
//     Route::resource('customer', CustomerController::class);
//     Route::resource('user', UserController::class);
//     Route::resource('member', MemberController::class);
//     Route::resource('order', OrderController::class);
//     Route::get('scanner', function () {return view('order.scanner');})->name('scanner');
//     Route::get('/order/qrscan/{qr_token}', [OrderController::class, 'qrscan'])->name('order.qrscan');
//     Route::get('/admin/profil', [DashboardController::class, 'profile'])->name('dashboard.profil');
//     Route::post('/admin/profile', [DashboardController::class, 'profileUpdate'])->name('update.profile.admin');
//     Route::post('/admin/profile/password', [DashboardController::class, 'updatePassword'])->name('update.password.admin');
//     Route::resource('application-setting', ApplicationSettingController::class);
// });
// Route::resource('payment', PaymentController::class);




Route::middleware('guest')->group(function (){

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot', [AuthController::class, 'showForgotForm'])->name('show-forgot');
    Route::post('/forgot', [AuthController::class, 'forgot'])->name('forgot');
    Route::get('/reset/{token}', fn(string $token) => view('auth.reset-password', ['token' => $token]))->name('password.reset');
    Route::post('/reset', [AuthController::class, 'reset'])->name('reset');
});