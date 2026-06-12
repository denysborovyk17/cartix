<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Checkout\ConfirmPaymentAction;
use App\Repositories\OrderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final readonly class OrderController
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    ) {
    }

    public function show(int $orderId): View
    {
        $order = $this->orderRepository->findById($orderId);

        return view('checkout.checkout-payment', compact('order'));
    }

    public function complete(ConfirmPaymentAction $action, int $orderId): RedirectResponse
    {
        $action->handle($orderId);

        return redirect()->route('orders.success', $orderId);
    }

    public function success(int $orderId): View
    {
        $order = $this->orderRepository->findById($orderId);

        return view('checkout.checkout-success', compact('order'));
    }
}
