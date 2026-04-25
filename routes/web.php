<?php declare(strict_types=1);

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('index'))->name('index');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('/categories/{category:slug}/products/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::middleware('web')->group(function () {
    Route::resource('/cart', CartController::class);
});
