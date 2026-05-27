<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Exceptions\ProductVariantOutOfStockException;
use App\Services\{CurrentCartService, CartService};
use Money\{Money, Currency};

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

        $itemTotal = (new Money($cartItem->productVariant->price, new Currency('USD')))->multiply($quantity);

        return [
            'quantity' => $quantity,
            'itemTotal' => $itemTotal,
            'cartTotal' => $this->cartService->calculateTotal()
        ];
    }
}
