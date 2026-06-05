<?php declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Enums\OrderStatus;
use App\Repositories\OrderRepository;
use App\Services\Cart\CurrentCartService;

readonly class ConfirmPaymentAction
{
    public function __construct(
        private OrderRepository $orderRepository,
        private CurrentCartService $currentCartService
    ) {
    }

    public function handle(int $orderId): void
    {
        $order = $this->orderRepository->findById($orderId);
        $order->update([
            'status' => OrderStatus::PAID
        ]);

        $cart = $this->currentCartService->findById();
        $cart->items()->delete();
    }
}
