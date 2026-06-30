<?php declare(strict_types=1);

namespace App\Actions\Admin\Order;

use App\Data\Admin\OrderData;
use App\Repositories\ProductRepository;
use App\Models\Order\{Order, OrderItem};
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class CreateOrderAction
{
    public function __construct(
        private ProductRepository $productRepository
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(OrderData $data, int $quantity = 1): Order
    {
        return DB::transaction(function () use ($data, $quantity): Order {
            $productVariants = $this->productRepository->findProductVariantByIds($data->getProductVariantIds());

            $total = 0;
            foreach ($productVariants as $productVariant) {
                $total += $productVariant->discount_price ?? $productVariant->price * $quantity;
            }

            $order = Order::create([
                'status' => $data->getStatus(),
                'total' => $total,
                'first_name' => $data->getFirstName(),
                'last_name' => $data->getLastName(),
                'email' => $data->getEmail(),
                'phone' => $data->getPhone(),
                'city' => $data->getCity(),
                'address' => $data->getAddress(),
                'notes' => $data->getNotes()
            ]);

            foreach ($productVariants as $productVariant) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $productVariant->id,
                    'product_name' => $productVariant->product->name,
                    'quantity' => $quantity,
                    'price' => $productVariant->discount_price ?? $productVariant->price
                ]);
            }

            return $order;
        });
    }
}
