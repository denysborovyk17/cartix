<?php declare(strict_types=1);

namespace App\Services;

use App\Services\Cart\CurrentCartService;

readonly class OrderService
{
    public function __construct(
        private CurrentCartService $currentCartService
    ) {
    }

    public function calculateTotal(): int
    {
        $cart = $this->currentCartService->findById();

        $total = 0;
        foreach ($cart->items as $cartItem) {
            if ($cartItem->productVariant->discount_price) {
                $total += $cartItem->productVariant->discount_price * $cartItem->quantity;
            } else {
                $total += $cartItem->productVariant->price * $cartItem->quantity;
            }
        }

        return $total;
    }
}
