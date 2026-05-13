<?php declare(strict_types=1);

namespace App\Providers;

use App\Models\Category;
use App\Services\CurrentCartService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'index'], function ($view) {
            $view->with([
                'categories' => Category::query()
                    ->select('id', 'name', 'slug')
                    ->get()
            ]);
        });
        View::composer('layouts.app', function ($view) {
            $cart = app(CurrentCartService::class)->getCurrentCart();

            $view->with(['cart' => $cart->load('items.productVariant.product')
            ]);
        });
    }
}
