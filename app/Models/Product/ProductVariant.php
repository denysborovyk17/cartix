<?php declare(strict_types=1);

namespace App\Models\Product;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

/**
 * @property int $id Унікальний ідентифікатор варіанта товару
 * @property int $product_id Унікальний ідентифікатор товару
 * @property int $price Ціна товару
 * @property int|null $discount_price Знижка на товар
 * @property int $stock Кількість товару на складі
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
 */
class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'discount_price',
        'stock'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(
            OptionValue::class,
            'product_variant_option_values',
            'product_variant_id',
            'option_value_id'
        );
    }
}
