<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Services\CartService;
use App\Services\CurrentCartService;
use Money\{Money, Currency};

readonly class UpdateCartItemAction
{
    public function __construct(
        private CurrentCartService $currentCartService,
        private CartService $cartService
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(int $productVariantId, int $quantity): array
    {
        $cart = $this->currentCartService->findById();

        $cartItem = $cart->findItemByProductVariantId($productVariantId);

        if ($cartItem && $cartItem->productVariant->stock >= $quantity) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        } else {
            throw new \Exception('Quantity out of stock');
        }

        $itemTotal = (new Money($cartItem->productVariant->price, new Currency('USD')))->multiply($quantity);

        return [
            'quantity' => $quantity,
            'itemTotal' => $itemTotal,
            'cartTotal' => $this->cartService->calculateTotal()
        ];
    }
}
