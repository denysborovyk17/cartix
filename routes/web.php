<?php declare(strict_types=1);

use App\Http\Controllers\{CartController, CategoryController, ProductController};
use App\Http\Controllers\Auth\{RegisterController, LoginController, LogoutController};
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('index'))->name('index');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('web')->group(function () {
    Route::resource('/cart', CartController::class)->except(['create', 'show', 'edit']);
});

Route::prefix('auth')->as('auth.')->group(function () {
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', RegisterController::class)->name('register.store');

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', LoginController::class)->middleware('throttle:login')->name('login.attempt');

    Route::post('/logout', LogoutController::class)->name('logout');
});
