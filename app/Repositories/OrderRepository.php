<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Order\Order;

class OrderRepository
{
    public function __construct(
        //
    ) {
    }

    public function findById(int $orderId): Order
    {
        return Order::query()->findOrFail($orderId);
    }
}
