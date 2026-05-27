<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Services\CartService;
use App\Services\CurrentCartService;

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
            'cartCounter' => $this->cartService->getItemsCount()
        ];
    }
}
