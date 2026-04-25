<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreCartItemRequest;
use App\Http\Requests\Cart\UpdateCartItemRequest;
use App\Models\ProductVariant;
use App\Services\Cart\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService
    ) {}

    public function index(): View
    {
        $productVariants = ProductVariant::with('product')->get();

        return view('cart', compact('productVariants'));
    }

    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $productVariantId = (int) $request->input('product_variant_id');

        $service = $this->cartService->addItem($productVariantId);

        return response()->json([
            'cart_item' => $service['cart_item'],
            'cart_counter' => $service['cart_counter']
        ]);
    }


    public function update(int $productVariantId, UpdateCartItemRequest $request): JsonResponse
    {
        $quantity = $request->input('quantity');

        $service = $this->cartService->updateItemQuantity($productVariantId, $quantity);

        return response()->json([
            'quantity' => $quantity,
            'item_total' => (int) $service['item_total'],
            'cart_total' => (int) $service['cart_total']
        ]);
    }

    public function destroy(int $productVariantId): JsonResponse
    {
        $service = $this->cartService->removeItem($productVariantId);

        return response()->json([
            'cart_total' => $service['cart_total']
        ]);
    }
}
