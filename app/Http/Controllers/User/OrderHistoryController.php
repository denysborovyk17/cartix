<?php declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Repositories\OrderRepository;
use Illuminate\View\View;

final readonly class OrderHistoryController
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {
    }

    public function index(): View
    {
        $user = auth()->user();

        $orders = $this->orderRepository->getHistory($user->id);

        return view('profile.order-history', compact('orders'));
    }
}
