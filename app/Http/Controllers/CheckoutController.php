<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Checkout\CreateOrderAction;
use App\Http\Requests\StoreCheckoutRequest;
use App\Services\Cart\CurrentCartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly CurrentCartService $currentCartService
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

        session(['order_id' => $order->id]);

        return redirect()->route('orders.payment', $order->id);
    }
}
