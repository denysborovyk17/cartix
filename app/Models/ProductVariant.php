<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/** @property mixed $product */
/** @property int $price */
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
