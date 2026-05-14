<?php declare(strict_types=1);

namespace App\Services;

use App\Models\CartItem;
use App\Repositories\ProductVariantRepository;
use Money\{Currency, Money};

class CartService
{
    public function __construct(
        private readonly CurrentCartService $currentCartService,
        private readonly ProductVariantRepository $productVariantRepository,
        private readonly MoneyFormatterService $moneyFormatterService
    ) {
    }

    public function addItem(int $productVariantId): array
    {
        $cart = $this->currentCartService->getCurrentCart();

        $cartItem = $cart->findItem($productVariantId);

        if ($cartItem) {
            $cartItem->quantity++;
        } else {
            $cartItem = new CartItem();
            $cartItem->cart_id = $cart->id;
            $cartItem->fill([
                'product_variant_id' => $productVariantId,
                'quantity' => 1
            ]);
        }
        $cartItem->save();

        return [
            'cartItem' => $cartItem->load('productVariant.product'),
            'cartCounter' => $this->getItemsCount()
        ];
    }

    public function updateItemQuantity(int $productVariantId, int $quantity): array
    {
        $cart = $this->currentCartService->getCurrentCart();

        $cartItem = $cart->findItem($productVariantId);

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        $productVariant = $this->productVariantRepository->getProductVariant($productVariantId);

        $itemTotal = (new Money($productVariant->price, new Currency('USD')))->multiply($quantity);

        return [
            'quantity' => $quantity,
            'itemTotal' => $this->moneyFormatterService->format($itemTotal),
            'cartTotal' => $this->moneyFormatterService->format($this->calculateTotal())
        ];
    }

    public function removeItem(int $productVariantId): array
    {
        $cart = $this->currentCartService->getCurrentCart();

        $cartItem = $cart->findItem($productVariantId);

        if ($cartItem) {
            $cartItem?->delete();
        }

        return [
            'cartTotal' => $this->moneyFormatterService->format($this->calculateTotal())
        ];
    }

    public function calculateTotal(): Money
    {
        $cart = $this->currentCartService->getCurrentCart();

        if ($cart->items->isEmpty()) {
            return new Money(0, new Currency('USD'));
        }

        $amounts = [];
        foreach ($cart->items as $cartItem) {
            $amounts[] = (new Money($cartItem->productVariant->price, new Currency('USD')))
                ->multiply($cartItem->quantity);
        }

        return Money::sum(...$amounts);
    }

    public function getItemsCount(): int
    {
        $cart = $this->currentCartService->getCurrentCart();

        $counter = 0;
        foreach ($cart->items as $cartItem) {
            $counter += $cartItem->quantity;
        }

        return $counter;
    }
}
