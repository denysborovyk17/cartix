<?php declare(strict_types=1);

namespace App\Providers;

use App\Models\Category;
use App\Services\{CurrentCartService, CartService};
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(CurrentCartService $currentCartService, CartService $cartService): void
    {
        View::composer(['layouts.app', 'index'], function ($view) {
            $view->with([
                'categories' => Category::query()
                    ->whereNotNull('parent_id')
                    ->get()
            ]);
        });

        View::composer('layouts.app', function ($view) use ($currentCartService, $cartService) {
            $cart = $currentCartService->getCurrentCart();

            $view->with([
                'cart' => $cart->load('items.productVariant.product')
            ]);

            $view->with([
                'cartCounter' => $cartService->getItemsCount()
            ]);
        });

        View::composer('cart', function ($view) use ($cartService) {
            $view->with([
                'cartTotal' => $cartService->calculateTotal()->getAmount()
            ]);
        });
    }
}
