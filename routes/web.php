<?php declare(strict_types=1);

use App\Http\Controllers\{CartController, CategoryController, ProductController, CheckoutController, OrderController, ReviewController, WishlistController};
use App\Http\Controllers\Auth\{RegisterController, LoginController, LogoutController, ForgotPasswordController, ResetPasswordController};
use App\Http\Controllers\Admin\{
    BrandController as AdminBrandController,
    UserController as AdminUserController,
    CategoryController as AdminCategoryController,
};
use App\Http\Controllers\User\{ProfileController, OrderHistoryController, PasswordController};
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('index'))->name('index');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::resource('/cart', CartController::class)->except('create', 'show', 'edit');

Route::middleware('guest')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', RegisterController::class)->name('register.store');

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', LoginController::class)->middleware('throttle:login')->name('login.attempt');

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
    Route::post('/payment/complete', [OrderController::class, 'complete'])->middleware('throttle:payment.complete')->name('payment.complete');
    Route::get('/success', [OrderController::class, 'success'])->name('success');
    Route::get('/fail', [OrderController::class, 'fail'])->name('fail');
});

Route::middleware('auth')->group(function () {
    Route::get('/reviews/products/{product:slug}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/products/{product:slug}', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/{productVariantId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::prefix('profile')->as('profile.')->group(function () {
        Route::get('/orders', [OrderHistoryController::class, 'index'])->name('orders');

        Route::get('/security', [PasswordController::class, 'index'])->name('security');
        Route::put('/security', [PasswordController::class, 'update'])->name('security.update');
    });
});

Route::get('/admin', fn() => view('sbadmin2.index'))->middleware('ensureIsAdmin')->name('admin.index');

Route::prefix('admin')->as('admin.')->middleware('ensureIsAdmin')->group(function () {
    Route::view('/profile', 'sbadmin2.profile')->name('profile');
    Route::view('/profile/security', 'sbadmin2.security')->name('profile.security');

    Route::view('/forgot-password', 'sbadmin2.forgot-password')->name('forgot.password');

    Route::resource('/brands', AdminBrandController::class)->except('show');
    Route::resource('/users', AdminUserController::class)->except('show');
    Route::resource('/categories', AdminCategoryController::class)->except('show');
});
