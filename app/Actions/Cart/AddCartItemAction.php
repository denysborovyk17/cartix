<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Services\Cart\CartService;
use App\Services\Cart\CurrentCartService;

readonly class AddCartItemAction
{
    public function __construct(
        private CurrentCartService $currentCartService,
        private CartService $cartService
    ) {}

    public function handle(int $productVariantId, int $quantity = 1): array
    {
        $cart = $this->currentCartService->findById();

        $cartItem = $cart->findItemByProductVariantId($productVariantId);

        if ($cartItem) {
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            $cartItemData = [
                'product_variant_id' => $productVariantId,
                'quantity' => $quantity
            ];
            $cartItem = $cart->items()->create($cartItemData);
        }
        $cartItem->load('productVariant.optionValues.option');

        return [
            'cartItem' => $cartItem,
            'itemTotal' => $this->cartService->calculateItemTotal($productVariantId),
            'cartTotal' => $this->cartService->calculateTotal(),
            'cartCounter' => $this->cartService->getItemsCount()
        ];
    }
}
