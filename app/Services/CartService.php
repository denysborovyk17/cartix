<?php declare(strict_types=1);

namespace App\Services\Cart;

use App\Repositories\CartRepository;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\AggregateMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;

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
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return [
            'cartItem' => $cart[$productVariantId],
            'cartCounter' => count(session('cart', []))
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
        $dollars = new Money($item['price'], new Currency('USD'));

        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $intlFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        $moneyFormatter = new AggregateMoneyFormatter([
            'USD' => $intlFormatter
        ]);

        $itemTotal = $dollars->multiply((int)$item['quantity']);

        $amounts = array_map(function($item) {
            $dollars = new Money($item['price'], new Currency('USD'));
            return $dollars->multiply((int)$item['quantity']);
        }, $cart);

        $cartTotal = Money::sum(...$amounts);

        return [
            'itemTotal' => $moneyFormatter->format($itemTotal),
            'cartTotal' => $moneyFormatter->format($cartTotal)
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
            'cartTotal' => $cartTotal
        ];
    }
}
