<?php declare(strict_types=1);

namespace App\Services;

use App\Repositories\ProductVariantRepository;
use Money\{Currency, Money};

class CartService
{
    public function __construct(
        private readonly CurrentCartService $currentCartService,
        private readonly ProductVariantRepository $productVariantRepository
    ) {
    }

    public function addItem(int $productVariantId, int $quantity = 1): array
    {
        $cart = $this->currentCartService->findById();

        $cartItem = $cart->findItemByProductVariantId($productVariantId);

        if ($cartItem) {
            $cartItem->quantity++;
        } else {
            $cartItemData = [
                'product_variant_id' => $productVariantId,
                'quantity' => $quantity
            ];
            $cartItem = $cart->items()->create($cartItemData);
        }
        $cartItem->load('productVariant.optionValues.option')->save();

        return [
            'cartItem' => $cartItem,
            'cartCounter' => $this->getItemsCount()
        ];
    }

    public function updateItemQuantity(int $productVariantId, int $quantity): array
    {
        $cart = $this->currentCartService->findById();

        $cartItem = $cart->findItemByProductVariantId($productVariantId);

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        $productVariant = $this->productVariantRepository->findById($productVariantId);

        $itemTotal = (new Money($productVariant->price, new Currency('USD')))->multiply($quantity);

        return [
            'quantity' => $quantity,
            'itemTotal' => $itemTotal,
            'cartTotal' => $this->calculateTotal()
        ];
    }

    public function removeItem(int $productVariantId): array
    {
        $cart = $this->currentCartService->findById();

        $cartItem = $cart->findItemByProductVariantId($productVariantId);

        if ($cartItem) {
            $cartItem->delete();
        }

        return [
            'cartTotal' => $this->calculateTotal()
        ];
    }

    public function calculateTotal(): Money
    {
        $cart = $this->currentCartService->findById();

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
        $cart = $this->currentCartService->findById();

        return $cart->items->sum('quantity');
    }
}
