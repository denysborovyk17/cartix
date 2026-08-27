<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Repositories\CartRepository;

readonly class MergeGuestCartAction
{
    public function __construct(
        private CartRepository $cartRepository
    ) {
    }

    public function handle(int $userId, ?string $sessionId): void
    {
        if (!$sessionId) {
            return;
        }

        $userCart = $this->cartRepository->findByUserId($userId);
        $guestCart = $this->cartRepository->findBySessionId($sessionId);

        if (!$guestCart) {
            return;
        }

        if ($userCart) {
            foreach ($guestCart->items as $cartItem) {
                $existingItem = $userCart->findItemByProductVariantId($cartItem->product_variant_id);

                if ($existingItem) {
                    $existingItem->update([
                        'quantity' => $existingItem->quantity + $cartItem->quantity
                    ]);
                } else {
                    $cartItem->update([
                        'cart_id' => $userCart->id
                    ]);
                }
            }

            $guestCart->delete();
            return;
        }

        $guestCart->update([
            'user_id' => $userId,
            'session_id' => null
        ]);
    }
}
