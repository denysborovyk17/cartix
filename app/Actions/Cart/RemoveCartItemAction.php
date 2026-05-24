<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Services\CartService;
use App\Services\CurrentCartService;

readonly class RemoveCartItemAction
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
