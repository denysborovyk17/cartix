<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Exceptions\ProductVariantOutOfStockException;
use App\Services\{Cart\CartService, Cart\CurrentCartService};

readonly class UpdateCartItemAction
{
    public function __construct(
        private CurrentCartService $currentCartService,
        private CartService $cartService
    ) {
    }

    /**
     * @throws ProductVariantOutOfStockException
     */
    public function handle(int $productVariantId, int $quantity): array
    {
        $cart = $this->currentCartService->findById();

        $cartItem = $cart->findItemByProductVariantId($productVariantId);

        if (!$cartItem) {
            abort(404, 'Item not found in cart.');
        }

        if ($cartItem->productVariant->stock < $quantity) {
            throw new ProductVariantOutOfStockException($productVariantId);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        $itemTotal = $this->cartService->calculateItemTotal($productVariantId);

        return [
            'quantity' => $quantity,
            'itemTotal' => $itemTotal,
            'cartTotal' => $this->cartService->calculateTotal()
        ];
    }
}
