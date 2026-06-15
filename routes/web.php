<?php declare(strict_types=1);

use App\Http\Controllers\{CartController, CategoryController, ProductController, CheckoutController, OrderController, ReviewController, WishlistController};
use App\Http\Controllers\Auth\{RegisterController, LoginController, LogoutController, ForgotPasswordController, ResetPasswordController};
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('index'))->name('index');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::resource('/cart', CartController::class)->except(['create', 'show', 'edit']);

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->as('auth.')->group(function () {
        Route::view('/register', 'auth.register')->name('register');
        Route::post('/register', RegisterController::class)->name('register.store');

        Route::view('/login', 'auth.login')->name('login');
        Route::post('/login', LoginController::class)->middleware('throttle:login')->name('login.attempt');
    });

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('password.update');
});

Route::post('/logout', LogoutController::class)->middleware('auth')->name('logout');

Route::get('/checkout', [CheckoutController::class, 'index'])->middleware('ensureCartIsNotEmpty')->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::prefix('orders/{orderId}')->as('orders.')->middleware('ensureOwnsOrder')->group(function () {
    Route::get('/payment', [OrderController::class, 'show'])->name('payment');
    Route::post('/payment/complete', [OrderController::class, 'complete'])->name('payment.complete');
    Route::get('/success', [OrderController::class, 'success'])->name('success');
});

Route::middleware('auth')->group(function () {
    Route::get('/reviews/products/{product:slug}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/products/{product:slug}', [ReviewController::class, 'store'])->name('reviews.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/{productVariantId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});
