<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\User\ToggleWishlistItemAction;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

final readonly class WishlistController
{
    public function __construct(
        //
    ) {
    }

    public function index(): View
    {
        $user = auth()->user();

        $wishlistItems = $user->wishlistItems()->with('product.variants')->paginate(config('custom.pagination.per_page'));

        return view('wishlist', compact('wishlistItems'));
    }

    public function toggle(ToggleWishlistItemAction $action, int $productVariantId): JsonResponse
    {
        $action = $action->handle($productVariantId);

        return response()->json([
            'wishlistCounter' => $action['wishlistCounter'],
            'status' => $action['status']
        ]);
    }
}
