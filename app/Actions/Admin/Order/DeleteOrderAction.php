<?php declare(strict_types=1);

namespace App\Actions\Admin\Order;

use App\Repositories\OrderRepository;

readonly class DeleteOrderAction
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {
    }

    public function handle(int $orderId): void
    {
        $order = $this->orderRepository->findById($orderId);

        $order->delete();
    }
}
