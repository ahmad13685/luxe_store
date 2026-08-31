<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\ProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Four parts:
|   1. Public website pages (Home, Shop, Product Details, Cart, About, Contact)
|   2. Cart bridge (syncs the JS/localStorage cart into the PHP session so
|      the server-side checkout has something to read)
|   3. Customer auth (Login, Register, Forgot Password, Logout)
|   4. Customer Dashboard + Checkout/Orders (protected - must be logged in)
*/

// ============================================================
// PUBLIC WEBSITE
// ============================================================
Route::get('/', function () {
    // Pass along which products (by name) the logged-in customer has
    // already wishlisted, so the heart icons render "active" on load
    // without needing an extra request. No new controller/route - this
    // just feeds the existing Wishlist model into the existing view.
    $wishlistMap = [];
    if (session('customer_id')) {
        $wishlistMap = \App\Models\Wishlist::where('customer_id', session('customer_id'))
            ->pluck('id', 'product_name')
            ->toArray();
    }
    return view('home', compact('wishlistMap'));
})->name('home');

Route::get('/shop', function () {
    $wishlistMap = [];
    if (session('customer_id')) {
        $wishlistMap = \App\Models\Wishlist::where('customer_id', session('customer_id'))
            ->pluck('id', 'product_name')
            ->toArray();
    }
    return view('shop', compact('wishlistMap'));
})->name('shop');
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// ============================================================
// CART BRIDGE (public - cart can exist before login)
// Takes the JS/localStorage cart and stores it in the PHP session
// under the "cart" key, in the shape OrderController expects:
// [{ name, price, quantity }, ...]
// ============================================================
Route::post('/cart/sync', [CartController::class, 'sync'])->name('cart.sync');


// ============================================================
// CUSTOMER MODULE (prefixed /customer, named customer.*)
// ============================================================
Route::prefix('customer')->name('customer.')->group(function () {

    // Guest pages
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/product/{product}', [ProductController::class, 'show'])
    ->name('product-details');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.submit');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected pages
    Route::middleware('customer.auth')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // ---- Checkout ----
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');

        // ---- Orders ----
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.detail');
        Route::get('/order/{id}/tracking', [OrderController::class, 'tracking'])->name('order.tracking');
        Route::post('/order/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
        // ---- Wishlist ----
        Route::get('/wishlist', [WishlistController::class, 'index'])
            ->name('wishlist');

        Route::post('/wishlist', [WishlistController::class, 'store'])
            ->name('wishlist.store');

        Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])
            ->name('wishlist.destroy');

        // ---- Profile ----
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');


        // Future:
        // Wishlist
        // Profile
        // Change Password
    });

});
