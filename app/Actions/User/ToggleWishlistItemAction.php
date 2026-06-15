<?php declare(strict_types=1);

namespace App\Actions\User;

use App\Services\WishlistService;

readonly class ToggleWishlistItemAction
{
    public function __construct(
        private WishlistService $wishlistService,
    ) {
    }

    public function handle(int $productVariantId): array
    {
        $user = auth()->user();

        $user->wishlistItems()->toggle($productVariantId);

        $status = $user->wishlistItems()->where('product_variant_id', $productVariantId)->exists();

        return [
            'wishlistCounter' => $this->wishlistService->getItemsCount(),
            'status' => $status,
        ];
    }
}
