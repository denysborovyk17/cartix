<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Cart;

class   CartRepository
{
    public function findOrCreate(?int $userId, string $sessionId): Cart
    {
        if ($userId) {
            return Cart::with(['items.productVariant.optionValues', 'items.productVariant.product'])
                ->firstOrCreate(['user_id' => $userId]);
        }

        return Cart::with(['items.productVariant.optionValues', 'items.productVariant.product'])
            ->firstOrCreate(['session_id' => $sessionId]);
    }

    public function findByUserId(int $userId): Cart|null
    {
        return Cart::with(['items.productVariant.optionValues', 'items.productVariant.product'])
            ->where('user_id', $userId)
            ->first();
    }

    public function findBySessionId(string $sessionId): Cart|null
    {
        return Cart::with(['items.productVariant.optionValues', 'items.productVariant.product'])
            ->where('session_id', $sessionId)
            ->first();
    }
}
