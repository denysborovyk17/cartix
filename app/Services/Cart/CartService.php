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

        if ($cartItem->productVariant->discount_price) {
            $itemTotal = (new Money($cartItem->productVariant->discount_price, new Currency('USD')))
                ->multiply($cartItem->quantity);
        } else {
            $itemTotal = (new Money($cartItem->productVariant->price, new Currency('USD')))
                ->multiply($cartItem->quantity);
        }

        return $itemTotal;
    }

    public function calculateTotal(): Money
    {
        $cart = $this->currentCartService->findById();

        if ($cart->items->isEmpty()) {
            return new Money(0, new Currency('USD'));
        }

        $amounts = [];
        foreach ($cart->items as $cartItem) {
            if ($cartItem->productVariant->discount_price) {
                $amounts[] = (new Money($cartItem->productVariant->discount_price, new Currency('USD')))
                    ->multiply($cartItem->quantity);
            } else {
                $amounts[] = (new Money($cartItem->productVariant->price, new Currency('USD')))
                    ->multiply($cartItem->quantity);
            }
        }

        return Money::sum(...$amounts);
    }

    public function getItemsCount(): int
    {
        $cart = $this->currentCartService->findById();

        return $cart->items->sum('quantity');
    }
}
