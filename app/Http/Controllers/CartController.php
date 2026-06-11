<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Cart\{AddCartItemAction, RemoveCartItemAction, UpdateCartItemAction};
use App\Exceptions\ProductVariantOutOfStockException;
use App\Http\Requests\Cart\{StoreCartItemRequest, UpdateCartItemRequest};
use App\Http\Resources\CartItemResource;
use App\Services\{Cart\CurrentCartService, MoneyFormatterService};
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

readonly class CartController
{
    public function __construct(
        private CurrentCartService $currentCartService,
        private MoneyFormatterService $moneyFormatterService
    ) {}

    public function index(): View
    {
        $cart = $this->currentCartService->findById();

        return view('cart', compact('cart'));
    }

    public function store(StoreCartItemRequest $request, AddCartItemAction $action): JsonResponse
    {
        $productVariantId = (int) $request->input('product_variant_id');

        $action = $action->handle($productVariantId);

        return response()->json([
            'cartItem' => new CartItemResource($action['cartItem']),
            'itemTotal' => $this->moneyFormatterService->format($action['itemTotal']),
            'cartTotal' => $this->moneyFormatterService->format($action['cartTotal']),
            'cartCounter' => $action['cartCounter']
        ]);
    }

    /**
     * @throws ProductVariantOutOfStockException
     */
    public function update(UpdateCartItemRequest $request, UpdateCartItemAction $action, int $productVariantId): JsonResponse
    {
        $quantity = $request->input('quantity');

        $action = $action->handle($productVariantId, $quantity);

        return response()->json([
            'quantity' => $action['quantity'],
            'itemTotal' => $this->moneyFormatterService->format($action['itemTotal']),
            'cartTotal' => $this->moneyFormatterService->format($action['cartTotal'])
        ]);
    }

    public function destroy(RemoveCartItemAction $action, int $productVariantId): JsonResponse
    {
        $action = $action->handle($productVariantId);

        return response()->json([
            'cartTotal' => $this->moneyFormatterService->format($action['cartTotal'])
        ]);
    }
}
