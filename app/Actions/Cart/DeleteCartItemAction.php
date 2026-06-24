<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Services\Cart\CartService;
use App\Services\Cart\CurrentCartService;

readonly class DeleteCartItemAction
{
    public function __construct(
        private CurrentCartService $currentCartService,
        private CartService $cartService
    ) {}

    public function handle(int $productVariantId): array
    {
        $cart = $this->currentCartService->findById();

        $cartItem = $cart->findItemByProductVariantId($productVariantId);

        if ($cartItem) {
            $cartItem->delete();
        }

        return [
            'cartTotal' => $this->cartService->calculateTotal()
        ];
    }
}
