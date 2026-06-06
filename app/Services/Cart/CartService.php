<?php declare(strict_types=1);

namespace App\Services\Cart;

use Money\{Currency, Money};

readonly class CartService
{
    public function __construct(
        private CurrentCartService $currentCartService
    ) {
    }

    public function calculateItemTotal(int $productVariantId): Money
    {
        $cart = $this->currentCartService->findById();

        $cartItem = $cart->findItemByProductVariantId($productVariantId);

        return $this->resolvePrice($cartItem->product_variant_id);
    }

    public function calculateTotal(): Money
    {
        $cart = $this->currentCartService->findById();

        if ($cart->items->isEmpty()) {
            return new Money(0, new Currency('USD'));
        }

        $amounts = [];
        foreach ($cart->items as $cartItem) {
            $amounts[] = $this->resolvePrice($cartItem->product_variant_id);
        }

        return Money::sum(...$amounts);
    }

    public function getItemsCount(): int
    {
        $cart = $this->currentCartService->findById();

        return $cart->items->sum('quantity');
    }

    private function resolvePrice(int $productVariantId): Money
    {
        $cart = $this->currentCartService->findById();

        $cartItem = $cart->findItemByProductVariantId($productVariantId);

        if ($cartItem->productVariant->discount_price) {
            $productVariantPrice = $cartItem->productVariant->discount_price;
        } else {
            $productVariantPrice = $cartItem->productVariant->price;
        }

        return (new Money($productVariantPrice, new Currency('USD')))->multiply($cartItem->quantity);
    }
}
