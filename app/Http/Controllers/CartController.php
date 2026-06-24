<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Cart\{CreateCartItemAction, DeleteCartItemAction, UpdateCartItemAction};
use App\Exceptions\ProductVariantOutOfStockException;
use App\Http\Requests\Cart\{StoreCartItemRequest, UpdateCartItemRequest};
use App\Http\Resources\CartItemResource;
use App\Services\{Cart\CurrentCartService, MoneyFormatterService};
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

final readonly class CartController
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

    public function store(StoreCartItemRequest $request, CreateCartItemAction $action): JsonResponse
    {
        $productVariantId = (int) $request->input('product_variant_id');

        $result = $action->handle($productVariantId);

        return response()->json([
            'cartItem' => new CartItemResource($result['cartItem']),
            'itemTotal' => $this->moneyFormatterService->format($result['itemTotal']),
            'cartTotal' => $this->moneyFormatterService->format($result['cartTotal']),
            'cartCounter' => $result['cartCounter']
        ]);
    }

    /**
     * @throws ProductVariantOutOfStockException
     */
    public function update(UpdateCartItemRequest $request, UpdateCartItemAction $action, int $productVariantId): JsonResponse
    {
        $quantity = $request->input('quantity');

        $result = $action->handle($productVariantId, $quantity);

        return response()->json([
            'quantity' => $action['quantity'],
            'itemTotal' => $this->moneyFormatterService->format($result['itemTotal']),
            'cartTotal' => $this->moneyFormatterService->format($result['cartTotal'])
        ]);
    }

    public function destroy(DeleteCartItemAction $action, int $productVariantId): JsonResponse
    {
        $result = $action->handle($productVariantId);

        return response()->json([
            'cartTotal' => $this->moneyFormatterService->format($result['cartTotal'])
        ]);
    }
}
