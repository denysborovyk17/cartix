<?php declare(strict_types=1);

namespace App\Services;

use App\Exceptions\ProductVariantNotFoundException;
use App\Repositories\CartRepository;
use Money\{Currency, Money};

class CartService
{
    public function __construct(
        private readonly CartRepository $cartRepository,
        private readonly MoneyFormatterService $moneyService
    ) {
    }

    public function addItem(int $productVariantId): array
    {
        $productVariant = $this->cartRepository->getProductVariant($productVariantId);

        $cart = session('cart', []);

        if (!isset($cart[$productVariantId])) {
            $cart[$productVariantId] = [
                'product_variant_id' => $productVariant->id,
                'name' => $productVariant->product->name,
                'image' => $productVariant->product->image,
                'price' => $productVariant->price,
                'quantity' => 1
            ];
        } else {
            $cart[$productVariantId]['quantity']++;
        }

        session()->put('cart', $cart);

        return [
            'cartItem' => $cart[$productVariantId],
            'cartCounter' => count(session('cart', []))
        ];
    }

    /**
     * @throws ProductVariantNotFoundException
     */
    public function updateItemQuantity(int $productVariantId, int $quantity): array
    {
        $productVariant = $this->cartRepository->getProductVariant($productVariantId);

        $cart = session('cart', []);

        if (!isset($cart[$productVariantId])) {
            // throw new ProductVariantNotFoundException($productVariantId);
        }

        $cart[$productVariantId]['quantity'] = $quantity;

        session()->put('cart', $cart);

        $itemTotal = (new Money($productVariant->price, new Currency('USD')))->multiply($quantity);

        return [
            'quantity' => $quantity,
            'itemTotal' => $this->moneyService->format($itemTotal),
            'cartTotal' => $this->moneyService->format($this->calculateCartTotal($cart))
        ];
    }

    /**
     * @throws ProductVariantNotFoundException
     */
    public function removeItem(int $productVariantId): array
    {
        $cart = session('cart', []);

        if (!isset($cart[$productVariantId])) {
            // throw new ProductVariantNotFoundException($productVariantId);
        }

        unset($cart[$productVariantId]);

        session()->put('cart', $cart);

        return [
            'cartTotal' => $this->moneyService->format($this->calculateCartTotal($cart))
        ];
    }

    private function calculateCartTotal(array $cart): Money|null
    {
        $amounts = [];
        foreach ($cart as $item) {
            $amounts[] = (new Money($item['price'], new Currency('USD')))->multiply($item['quantity']);
        }

        if (empty($cart)) {
            return new Money(0, new Currency('USD'));
        }

        return Money::sum(...$amounts);
    }
}
