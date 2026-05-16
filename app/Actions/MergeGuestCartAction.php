<?php declare(strict_types=1);

namespace App\Actions;

use App\Repositories\CartRepository;

class MergeGuestCartAction
{
    public function __construct(
        private readonly CartRepository $cartRepository
    ) {
    }

    public function execute(int $userId, string $sessionId): void
    {
        $guestCart = $this->cartRepository->findCartBySessionId($sessionId);
        $userCart = $this->cartRepository->findCartByUserId($userId);

        if (!$guestCart) {
            return;
        }

        if ($userCart) {
            foreach ($guestCart->items as $cartItem) {
                $existingItem = $userCart->findItem($cartItem->product_variant_id);

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
