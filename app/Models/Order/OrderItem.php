<?php declare(strict_types=1);

namespace App\Models\Order;

use App\Models\Product\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $order_id Унікальний ідентифікатор замовлення
 * @property int $product_variant_id Унікальний ідентифікатор варіанта товару
 * @property int $quantity Кількість товару в кошику
 * @property int $price Ціна товару на момент оформлення замовлення
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'quantity',
        'price'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
