<?php declare(strict_types=1);

namespace App\Services\Cart;

use App\Repositories\Cart\CartRepository;

class CartService
{
    public function __construct(
        private readonly CartRepository $cartRepository
    ) {}

    public function addItem(int $productVariantId): array
    {
        $productVariant = $this->cartRepository->getProductVariant($productVariantId);

        $cart = session('cart', []);

        if (isset($cart[$productVariantId])) {
            $cart[$productVariantId]['quantity']++;
        } else {
            $cart[$productVariantId] = [
                'variant_id' => $productVariantId,
                'name' => $productVariant->product->name,
                'slug' => $productVariant->product->slug,
                'image' => $productVariant->product->image,
                'price' => $productVariant->price,
                'quantity' => 1,
                'options' => $productVariant->options
            ];
        }

        session()->put('cart', $cart);

        return [
            'cart_item' => $cart[$productVariantId],
            'cart_counter' => count(session('cart', []))
        ];
    }

    public function updateItemQuantity(int $productVariantId, int $quantity): array
    {
        $cart = session('cart', []);

        if (!isset($cart[$productVariantId])) {
            // throw Exception
        }

        $cart[$productVariantId]['quantity'] = $quantity;

        session()->put('cart', $cart);

        $item = $cart[$productVariantId];
        $itemTotal = $item['price'] * $item['quantity'];
        $cartTotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return [
            'item_total' => $itemTotal,
            'cart_total' => $cartTotal
        ];
    }

    public function removeItem(int $productVariantId): array
    {
        $cart = session('cart', []);

        if (!isset($cart[$productVariantId])) {
            // throw Exception
        }

        unset($cart[$productVariantId]);

        session()->put('cart', $cart);

        $cartTotal = collect(session('cart'))->sum(fn($item) => $item['price'] * $item['quantity']);

        return [
            'cart_total' => $cartTotal
        ];
    }
}
