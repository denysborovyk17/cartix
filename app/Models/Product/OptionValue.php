<?php declare(strict_types=1);

namespace App\Models\Product;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id Унікальний ідентифікатор значення опції
 * @property int $option_id Унікальний ідентифікатор опції товару
 * @property string $value Значення опції товару
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
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
