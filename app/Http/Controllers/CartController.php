<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\CartItemResource;
use App\Services\{CurrentCartService, CartService};
use App\Http\Requests\Cart\{StoreCartItemRequest, UpdateCartItemRequest};
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CurrentCartService $currentCartService,
        private readonly CartService $cartService
    ) {}

    public function index(): View
    {
        $cart = $this->currentCartService->getCurrentCart();

        return view('cart', compact('cart'));
    }

    public function store(StoreCartItemRequest $request): JsonResponse
    {
        $productVariantId = (int) $request->input('product_variant_id');

        $service = $this->cartService->addItem($productVariantId);

        return response()->json([
            'cartItem' => new CartItemResource($service['cartItem']),
            'cartCounter' => $service['cartCounter']
        ]);
    }

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

    public function destroy(int $productVariantId): JsonResponse
    {
        $service = $this->cartService->removeItem($productVariantId);

        return response()->json([
            'cartTotal' => $service['cartTotal']
        ]);
    }
}
