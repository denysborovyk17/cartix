<?php declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Data\ConfirmPaymentData;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Exceptions\ProductVariantOutOfStockException;
use App\Models\Payment\Payment;
use App\Repositories\OrderRepository;
use App\Services\Cart\CurrentCartService;
use App\Services\FakePaymentGatewayService;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class ConfirmPaymentAction
{
    public function __construct(
        private OrderRepository $orderRepository,
        private CurrentCartService $currentCartService,
        private FakePaymentGatewayService $fakePaymentGatewayService
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(ConfirmPaymentData $data, int $orderId): array
    {
        return DB::transaction(function () use ($data, $orderId): array  {
            $order = $this->orderRepository->findById($orderId);

            $order->update([
                'status' => OrderStatus::PENDING
            ]);

            $chance = $this->fakePaymentGatewayService->emulation();

            if ($chance) {
                foreach ($order->items as $orderItem) {
                    $productVariant = $orderItem->productVariant()->lockForUpdate()->first();

                    if ($productVariant->stock < $orderItem->quantity) {
                        throw new ProductVariantOutOfStockException($productVariant->id);
                    }

                    $productVariant->decrement('stock', $orderItem->quantity);
                }

                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $order->total,
                    'status' => PaymentStatus::SUCCESS,
                    'card_last4' => substr($data->getLastCard4(), -4),
                    'gateway' => 'Monobank'
                ]);

                $order->update([
                    'status' => OrderStatus::PAID
                ]);

                $cart = $this->currentCartService->findById();
                $cart->items()->delete();
            } else {
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $order->total,
                    'status' => PaymentStatus::FAILED,
                    'card_last4' => substr($data->getLastCard4(), -4),
                    'gateway' => 'Monobank'
                ]);

                $order->update([
                    'status' => OrderStatus::CANCELLED
                ]);
            }

            return [
                'order' => $order,
                'payment' => $payment,
                'chance' => $chance
            ];
        });
    }
}
