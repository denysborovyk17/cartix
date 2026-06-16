<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Order\Order;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class OrderRepository
{
    public function __construct(
        //
    ) {
    }

    public function findById(int $orderId): Order
    {
        return Order::query()->findOrFail($orderId);
    }

    public function getHistory(int $userId): LengthAwarePaginator
    {
        return Order::query()
            ->where('user_id', $userId)
            ->latest()
            ->paginate(config('custom.pagination.per_page'));
    }
}
