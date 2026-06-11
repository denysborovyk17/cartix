<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Models\Cart\CartItem;
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
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $productVariantId,
                'quantity' => $quantity
            ]);
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
