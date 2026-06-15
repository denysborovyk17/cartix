<?php declare(strict_types=1);

namespace App\Services;

readonly class WishlistService
{
    public function __construct(
        //
    ) {
    }

    public function getItemsCount(): int|null
    {
        $user = auth()->user();

        return $user?->wishlistItems()->count();
    }
}
