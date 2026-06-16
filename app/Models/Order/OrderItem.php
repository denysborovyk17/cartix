<?php declare(strict_types=1);

namespace App\Models\Order;

use App\Models\Product\ProductVariant;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id Унікальний ідентифікатор предмета замовлення
 * @property int $order_id Унікальний ідентифікатор замовлення
 * @property int $product_variant_id Унікальний ідентифікатор варіанта товару
 * @property string $product_name Назва товару
 * @property int $quantity Кількість товару в кошику
 * @property int $price Ціна товару на момент оформлення замовлення
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_variant_id',
        'product_name',
        'quantity',
        'price'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
