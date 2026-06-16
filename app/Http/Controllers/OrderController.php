<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Checkout\ConfirmPaymentAction;
use App\Http\Requests\ConfirmPaymentRequest;
use App\Models\Payment\Payment;
use App\Repositories\{OrderRepository, PaymentRepository};
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

final readonly class OrderController
{
    public function __construct(
        private OrderRepository $orderRepository,
        private PaymentRepository $paymentRepository
    ) {
    }

    public function show(int $orderId): View
    {
        $order = $this->orderRepository->findById($orderId);

        return view('checkout.checkout-payment', compact('order'));
    }

    /**
     * @throws Throwable
     */
    public function complete(ConfirmPaymentRequest $request, ConfirmPaymentAction $action, int $orderId): RedirectResponse
    {
        $action = $action->handle($request->getData(), $orderId);

        if ($action['chance']) {
            return redirect()->route('orders.success', $orderId);
        }

        return redirect()->route('orders.fail', $action['payment']->id);
    }

    public function success(int $orderId): View
    {
        $order = $this->orderRepository->findById($orderId);

        return view('checkout.checkout-success', compact('order'));
    }

    public function fail(int $paymentId): View
    {
        $payment = $this->paymentRepository->findById($paymentId);

        return view('checkout.checkout-fail', compact('payment'));
    }
}
