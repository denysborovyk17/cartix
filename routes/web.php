<?php declare(strict_types=1);

use App\Http\Controllers\{CartController, CategoryController, ProductController};
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('index'))->name('index');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('web')->group(function () {
    Route::resource('/cart', CartController::class);
});
