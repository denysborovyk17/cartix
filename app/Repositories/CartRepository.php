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

    public function findCartByUserId(int $userId): Cart|null
    {
        return Cart::with('items')
            ->where('user_id', $userId)
            ->first();
    }

    public function findCartBySessionId(string $sessionId): Cart|null
    {
        return Cart::with('items')
            ->where('session_id', $sessionId)
            ->first();
    }
}
