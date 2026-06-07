<?php declare(strict_types=1);

namespace App\Actions\Checkout;

use App\DTO\CreateOrderData;
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
                $productVariant = $cartItem->productVariant()->lockForUpdate()->first();

                if ($productVariant->stock < $cartItem->quantity) {
                    throw new ProductVariantOutOfStockException($productVariant->id);
                }

                $productVariant->decrement('stock', $cartItem->quantity);

                $order->items()->create([
                    'product_variant_id' => $productVariant->id,
                    'product_name' => $productVariant->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $productVariant->price
                ]);
            }

            return $order;
        });
    }
}
