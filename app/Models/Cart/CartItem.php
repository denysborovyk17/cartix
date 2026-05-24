<?php declare(strict_types=1);

namespace App\Models\Cart;

use App\Models\Product\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $cart_id Унікальний ідентифікатор кошика
 * @property int $product_variant_id Унікальний ідентифікатор варіанта товару
 * @property int $quantity Кількість товару в кошику
 */
class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_variant_id',
        'quantity'
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
