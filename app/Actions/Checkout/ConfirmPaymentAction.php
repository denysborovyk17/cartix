<?php declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Enums\OrderStatus;
use App\Exceptions\ProductVariantOutOfStockException;
use App\Models\Order\Order;
use App\Repositories\OrderRepository;
use App\Services\Cart\CurrentCartService;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class ConfirmPaymentAction
{
    public function __construct(
        private OrderRepository $orderRepository,
        private CurrentCartService $currentCartService
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(int $orderId): Order
    {
        return DB::transaction(function () use ($orderId): Order  {
            $order = $this->orderRepository->findById($orderId);

            foreach ($order->items as $orderItem) {
                $productVariant = $orderItem->productVariant()->lockForUpdate()->first();

                if ($productVariant->stock < $orderItem->quantity) {
                    throw new ProductVariantOutOfStockException($productVariant->id);
                }

                $productVariant->decrement('stock', $orderItem->quantity);
            }

            $order->update([
                'status' => OrderStatus::PAID
            ]);

            $cart = $this->currentCartService->findById();
            $cart->items()->delete();

            return $order;
        });
    }
}
