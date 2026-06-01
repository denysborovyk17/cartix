<?php declare(strict_types=1);

namespace App\Services\Cart;

use App\Models\Cart\Cart;
use App\Repositories\CartRepository;

readonly class CurrentCartService
{
    public function __construct(
        private CartRepository $cartRepository
    ) {
    }

    public function findById(): Cart
    {
        return $this->cartRepository->findOrCreate(auth()->id(), session()->getId());
    }
}
