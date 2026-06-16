<?php declare(strict_types=1);

namespace App\Actions\Checkout;

use App\Data\CreateOrderData;
use App\Enums\OrderStatus;
use App\Exceptions\ProductVariantOutOfStockException;
use App\Models\Order\Order;
use App\Services\Cart\CurrentCartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class CreateOrderAction
{
    public function __construct(
        private CurrentCartService $currentCartService,
        private OrderService $orderService
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(CreateOrderData $data): Order
    {
        return DB::transaction(function () use ($data): Order {
            $order = Order::create([
                'user_id' => auth()->id() ?? null,
                'status' => OrderStatus::PENDING,
                'total' => $this->orderService->calculateTotal(),
                'first_name' => $data->getFirstName(),
                'last_name' => $data->getLastName(),
                'email' => $data->getEmail(),
                'phone' => $data->getPhone(),
                'city' => $data->getCity(),
                'address' => $data->getAddress(),
                'notes' => $data->getNotes()
            ]);

            $cart = $this->currentCartService->findById();

            foreach ($cart->items as $cartItem) {
                if ($cartItem->productVariant->stock < $cartItem->quantity) {
                    throw new ProductVariantOutOfStockException($cartItem->productVariant->id);
                }

                $order->items()->create([
                    'product_variant_id' => $cartItem->productVariant->id,
                    'product_name' => $cartItem->productVariant->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->productVariant->price
                ]);
            }

            return $order;
        });
    }
}
