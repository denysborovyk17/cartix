<?php declare(strict_types=1);

namespace App\Models\Option;

use App\Models\Product\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $option_id Унікальний ідентифікатор опції товару
 * @property string $value Значення опції товару
 */
class OptionValue extends Model
{
    protected $fillable = [
        'option_id',
        'value'
    ];

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    public function productVariants(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'product_variant_option_values',
            'option_value_id',
            'product_variant_id'
        );
    }
}
