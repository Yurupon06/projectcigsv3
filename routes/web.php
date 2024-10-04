<?php

use App\Http\Controllers\LandingSettingController;
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

Route::get('/f&b', [LandingController::class, 'complement'])->name('f&b.index');

Route::get('/cart', [LandingController::class, 'cart'])->name('cart.index');
Route::post('/cart', [LandingController::class, 'updateCart'])->name('update.cart');
Route::get('/', [LandingController::class, 'home'])->name('home.index');
// Auth
Route::middleware('auth')->group(function () {
    Route::get('/home', [LandingController::class, 'index'])->name('landing.index');    
    // Customer
    Route::middleware('customer')->group(function () {
        Route::get('/home', [LandingController::class, 'index'])->name('landing.index');
        Route::prefix('/profile')->group(function () {
            Route::get('/', [LandingController::class, 'profile'])->name('landing.profile');
            Route::post('/', [LandingController::class, 'profileUpdate'])->name('update.profile');
            Route::post('/password', [LandingController::class, 'updatePassword'])->name('update.password');
        });
        route::prefix('/edit')->group(function () {
            Route::get('/profile', [LandingController::class, 'editProfile'])->name('landing.edit');
            Route::get('/password', [LandingController::class, 'changePass'])->name('landing.change');
        });
        Route::get('/getin', [LandingController::class, 'getIn'])->name('getin.index');
        
        Route::prefix('/myorder')->group(function () {
            Route::get('/', [LandingController::class, 'order'])->name('yourorder.index');
            Route::post('/', [LandingController::class, 'orderStore'])->name('yourorder.update');
            Route::patch('/{id}', [LandingController::class, 'orderCancel'])->name('yourorder.cancel');
            Route::patch('/complement/{id}', [LandingController::class, 'complementCancel'])->name('complement.cancel');
        });

        Route::get('/checking', [LandingController::class, 'beforeOrder'])->name('beforeorder.index');
        Route::get('/checkout/{id}', [LandingController::class, 'checkout'])->name('checkout');
        Route::get('/checkout/complement/{id}', [LandingController::class, 'showCheckoutComplement'])->name('checkout.complement');
        Route::post('/checkout/complement', [LandingController::class, 'checkoutComplement'])->name('checkout.complement.store');
        Route::get('/membership/{id}', [LandingController::class, 'membership'])->name('customer.membership');
        Route::get('/history', [LandingController::class, 'history'])->name('landing.history');
        
        Route::get('/complement/{id}', [LandingController::class, 'complementDetail'])->name('complement.detail');
        Route::post('/cart/add/{complementId}', [LandingController::class, 'addToCart'])->name('cart.add');
        Route::delete('/cart/remove/{id}', [LandingController::class, 'deleteCart'])->name('cart.remove');
        Route::post('/update-cart-cookie', [LandingController::class, 'updateCartCookie']);



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
        Route::resource('complements', ComplementController::class);
        Route::view('scanner', 'order.scanner')->name('scanner');
        Route::get('/order/qrscan/{qr_token}', [OrderController::class, 'qrscan'])->name('order.qrscan');

        Route::prefix('/admin')->group(function () {
            Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
            Route::post('/profile', [DashboardController::class, 'profileUpdate'])->name('update.profile.admin');
            Route::post('/profile/password', [DashboardController::class, 'updatePassword'])->name('update.password.admin');
        });

        Route::resource('application-setting', ApplicationSettingController::class);
        Route::resource('landing-settings', LandingSettingController::class);

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
            Route::get('/detailpayment/{id}', [CashierController::class, 'detailpayment'])->name('cashier.detailpayment');
            Route::get('/membercheckin', [CashierController::class, 'membercheckin'])->name('cashier.membercheckin');
            Route::view('/qrcheckin', 'cashier.qrcheckin')->name('qrcheckin.cashier');
            Route::get('/qrcheckin/{qr_token}', [MemberCheckinController::class, 'qrcheckin'])->name('cashier.qrcheckin');
            Route::get('/checkin-scanner', [CashierController::class, 'qrscanner'])->name('cashier.checkin');
            Route::get('/order', [CashierController::class, 'order'])->name('cashier.order');
            Route::post('/profile', [CashierController::class, 'profileUpdate'])->name('update.profile.cashier');
            Route::post('/profile/password', [CashierController::class, 'updatePassword'])->name('update.password.cashier');
            Route::post('/makeorder', [CashierController::class, 'makeOrder'])->name('make.order');
            Route::get('/receipt/{paymentId}', [CashierController::class, 'struk'])->name('cashier.receipt');
            Route::get('/membership', [CashierController::class, 'membercashier'])->name('membercashier.membercash');
            Route::get('/member/{id}', [CashierController::class, 'detailMember'])->name('cashier.member');
            Route::post('/member/action/{id}', [CashierController::class, 'actionMember'])->name('action.member');
            Route::get('/complement', [CashierController::class, 'orderComplement'])->name('cashier.complement');
            Route::post('/cart/add/{complementId}', [CashierController::class, 'addToCart'])->name('cart.added');
            Route::delete('/cart/remove/{id}', [CashierController::class, 'deleteCart'])->name('cart.deleted');
            Route::post('/cart/update/{id}', [CashierController::class, 'updateQuantity'])->name('cart.update');
            Route::post('/cart/checkout', [CashierController::class, 'checkoutProccess'])->name('cart.checkout');
            Route::get('/complement/{qr_token}', [CashierController::class, 'checkoutComplement'])->name('cashier.checkout');




        });

        Route::post('/payments/{order}', [CashierController::class, 'store'])->name('payments.store');
        Route::post('/payments/complement/{orderComplement}', [CashierController::class, 'paymentComplement'])->name('payments.complement');
        Route::get('/struk-gym/{id}', [CashierController::class, 'showStruk'])->name('struk_gym');
        Route::get('/struk-complement/{id}', [CashierController::class, 'strukComplement'])->name('struk_complement');
        Route::post('/customer/store', [CashierController::class, 'storeCustomer'])->name('customer.store');
        Route::resource('members', MemberController::class);
        Route::get('/member-details/{qr_token}', [CashierController::class, 'getMemberDetails']);
        Route::post('/store-checkin', [CashierController::class, 'storeCheckIn']);
    });

    Route::resource('payment', PaymentController::class);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

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