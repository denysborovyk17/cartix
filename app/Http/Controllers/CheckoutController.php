<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Checkout\{CreateOrderAction, ConfirmPaymentAction};
use App\Http\Requests\StoreCheckoutRequest;
use App\Repositories\OrderRepository;
use App\Services\Cart\CurrentCartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CurrentCartService $currentCartService,
        private readonly OrderRepository $orderRepository
    ) {
    }

    public function index(): View
    {
        $cart = $this->currentCartService->findById();

        return view('checkout.checkout', compact('cart'));
    }

    /**
     * @throws Throwable
     */
    public function store(StoreCheckoutRequest $request, CreateOrderAction $action): RedirectResponse
    {
        $order = $action->handle($request->toDTO());

        return redirect()->route('checkout.payment', ['orderId' => $order->id]);
    }

    public function showPayment(int $orderId): View
    {
        $order = $this->orderRepository->findById($orderId);

        return view('checkout.checkout-payment', compact('order'));
    }

    public function confirmPayment(ConfirmPaymentAction $action, int $orderId): RedirectResponse
    {
        $action->handle($orderId);

        return redirect()->route('index');
    }
}
