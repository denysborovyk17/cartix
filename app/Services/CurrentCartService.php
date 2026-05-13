<?php declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;
use App\Repositories\CartRepository;

class CurrentCartService
{
    public function __construct(
        private readonly CartRepository $cartRepository
    ) {
    }

    public function getCurrentCart(): Cart
    {
        return $this->cartRepository->getOrCreate(auth()->id(), session()->getId());
    }
}
