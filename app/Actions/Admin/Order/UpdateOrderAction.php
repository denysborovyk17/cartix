<?php declare(strict_types=1);

namespace App\Actions\Admin\Order;

use App\Data\Admin\OrderData;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use App\Models\Order\Order;
use App\Repositories\OrderRepository;
use Throwable;

readonly class UpdateOrderAction
{
    public function __construct(
        private ProductRepository $productRepository,
        private OrderRepository $orderRepository
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(OrderData $data, int $orderId, $quantity = 1): Order
    {
        return DB::transaction(function () use ($data, $orderId, $quantity): Order {
            $productVariants = $this->productRepository->findProductVariantByIds($data->getProductVariantIds());
            $order = $this->orderRepository->findById($orderId);

            $total = 0;
            foreach ($productVariants as $productVariant) {
                $total += ($productVariant->discount_price ?? $productVariant->price) * $quantity;
            }

            $order->update([
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

            $order->items()->delete();

            $itemsData = [];
            foreach ($productVariants as $productVariant) {
                $itemsData[] = [
                    'product_variant_id' => $productVariant->id,
                    'product_name' => $productVariant->product->name,
                    'quantity' => $quantity,
                    'price' => $productVariant->discount_price ?? $productVariant->price
                ];
            }

            $order->items()->createMany($itemsData);

            return $order;
        });
    }
}
