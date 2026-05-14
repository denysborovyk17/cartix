<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Cart;

class CartRepository
{
    public function getOrCreate(?int $userId, string $sessionId): Cart
    {
        if ($userId) {
            return Cart::with('items.productVariant.product')
                ->firstOrCreate(['user_id' => $userId]);
        }

        return Cart::with('items.productVariant.product')
            ->firstOrCreate(['session_id' => $sessionId]);
    }
}
