<?php declare(strict_types=1);

use App\Http\Controllers\{CartController, CategoryController, ProductController, CheckoutController};
use App\Http\Controllers\Auth\{RegisterController, LoginController, LogoutController, ForgotPasswordController, ResetPasswordController};
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('index'))->name('index');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('web')->group(function () {
    Route::resource('/cart', CartController::class)->except(['create', 'show', 'edit']);
});

Route::middleware('guest')->group(function () {
    Route::prefix('auth')->as('auth.')->group(function () {
        Route::view('/register', 'auth.register')->name('register');
        Route::post('/register', RegisterController::class)->name('register.store');

        Route::view('/login', 'auth.login')->name('login');
        Route::post('/login', LoginController::class)->middleware('throttle:login')->name('login.attempt');
    });

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', LogoutController::class)->middleware('auth')->name('logout');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout-payment/{orderId}', [CheckoutController::class, 'showPayment'])->name('checkout.payment');
Route::post('/checkout-payment/{orderId}/success', [CheckoutController::class, 'confirmPayment'])->name('checkout.payment.store');
