<?php declare(strict_types=1);

namespace App\Providers;

use App\Actions\User\ToogleWishlistItemAction;
use App\Models\Product\Category;
use App\Services\{Cart\CartService, Cart\CurrentCartService, WishlistService};
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
    public function boot(CurrentCartService $currentCartService, CartService $cartService, WishlistService $wishlistService): void
    {
        View::composer(['layouts.app', 'index'], function ($view) {
            $view->with([
                'categories' => Category::query()
                    ->whereNotNull('parent_id')
                    ->get()
            ]);
        });

        View::composer('layouts.app', function ($view) use ($currentCartService, $cartService, $wishlistService) {
            $cart = $currentCartService->findById();

            $view->with([
                'cart' => $cart->load(['items.productVariant.product', 'items.productVariant.optionValues'])
            ]);

            $view->with([
                'cartCounter' => $cartService->getItemsCount()
            ]);

            $view->with([
                'wishlistCounter' => $wishlistService->getItemsCount()
            ]);
        });

        View::composer(['layouts.app', 'cart', 'checkout.checkout'], function ($view) use ($cartService) {
            $view->with([
                'cartTotal' => $cartService->calculateTotal()->getAmount()
            ]);
        });
    }
}
