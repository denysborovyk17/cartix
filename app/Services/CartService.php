<?php declare(strict_types=1);

namespace App\Services;

use Money\{Currency, Money};

readonly class CartService
{
    public function __construct(
        private CurrentCartService $currentCartService
    ) {
    }

    public function calculateTotal(): Money
    {
        $cart = $this->currentCartService->findById();

        if ($cart->items->isEmpty()) {
            return new Money(0, new Currency('USD'));
        }

        $amounts = [];
        foreach ($cart->items as $cartItem) {
            $amounts[] = (new Money($cartItem->productVariant->price, new Currency('USD')))
                ->multiply($cartItem->quantity);
        }

        return Money::sum(...$amounts);
    }

    public function getItemsCount(): int
    {
        $cart = $this->currentCartService->findById();

        return $cart->items->sum('quantity');
    }
}
