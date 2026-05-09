<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\ProductVariantNotFoundException;
use App\Http\Requests\Cart\{StoreCartItemRequest, UpdateCartItemRequest};
use App\Models\ProductVariant;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
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
            'cartItem' => $service['cartItem'],
            'cartCounter' => $service['cartCounter']
        ]);
    }

    /**
     * @throws ProductVariantNotFoundException
     */
    public function update(int $productVariantId, UpdateCartItemRequest $request): JsonResponse
    {
        $quantity = $request->input('quantity');

        $service = $this->cartService->updateItemQuantity($productVariantId, $quantity);

        return response()->json([
            'quantity' => $service['quantity'],
            'itemTotal' => $service['itemTotal'],
            'cartTotal' => $service['cartTotal']
        ]);
    }

    /**
     * @throws ProductVariantNotFoundException
     */
    public function destroy(int $productVariantId): JsonResponse
    {
        $service = $this->cartService->removeItem($productVariantId);

        return response()->json([
            'cartTotal' => $service['cartTotal']
        ]);
    }
}
