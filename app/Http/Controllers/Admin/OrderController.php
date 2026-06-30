<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Order\{CreateOrderAction, UpdateOrderAction, DeleteOrderAction};
use App\Http\Requests\Admin\Order\{StoreOrderRequest, UpdateOrderRequest};
use App\Repositories\{OrderRepository, ProductRepository};
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

final readonly class OrderController
{
    public function __construct(
        private ProductRepository $productRepository,
        private OrderRepository $orderRepository,
    ) {
    }

    public function index(): View
    {
        $orders = $this->orderRepository->getAll();

        return view('sbadmin2.tables.orders.index', compact('orders'));
    }

    public function create(): View
    {
        $productVariants = $this->productRepository->getAllProductVariantsCollection();

        return view('sbadmin2.tables.orders.create', compact('productVariants'));
    }

    /**
     * @throws Throwable
     */
    public function store(StoreOrderRequest $request, CreateOrderAction $action): RedirectResponse
    {
        $action->handle($request->getData());

        return redirect()->back();
    }

    public function edit(int $orderId): View
    {
        $order = $this->orderRepository->findById($orderId);
        $productVariants = $this->productRepository->getAllProductVariantsCollection();

        return view('sbadmin2.tables.orders.edit', compact('productVariants', 'order'));
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateOrderRequest $request, UpdateOrderAction $action, int $orderId): RedirectResponse
    {
        $action->handle($request->getData(), $orderId);

        return redirect()->back();
    }

    public function destroy(DeleteOrderAction $action, int $orderId): RedirectResponse
    {
        $action->handle($orderId);

        return redirect()->back();
    }
}
