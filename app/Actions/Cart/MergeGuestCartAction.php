<?php declare(strict_types=1);

namespace App\Actions\Cart;

use App\Repositories\CartRepository;

readonly class MergeGuestCartAction
{
    public function __construct(
        private CartRepository $cartRepository
    ) {
    }

    public function handle(int $userId, string $sessionId): void
    {
        $userCart = $this->cartRepository->findByUserId($userId);
        $guestCart = $this->cartRepository->findBySessionId($sessionId);

        if (!$guestCart) {
            return;
        }

        if ($userCart) {
            foreach ($guestCart->items as $cartItem) {
                $existingItem = $userCart->findItemByProductVariantId($cartItem->product_variant_id);

                if ($existingItem) {
                    $existingItem->quantity += $cartItem->quantity;
                    $existingItem->save();
                } else {
                    $cartItem->cart_id = $userCart->id;
                    $cartItem->save();
                }
            }

            $guestCart->delete();
            return;
        }

        $guestCart->user_id = $userId;
        $guestCart->session_id = null;
        $guestCart->save();
    }
}
