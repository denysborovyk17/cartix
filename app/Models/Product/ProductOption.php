<?php declare(strict_types=1);

namespace App\Models\Product;

use App\Models\Option\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $product_id
 * @property int $option_id
 */
class ProductOption extends Model
{
    protected $fillable = [
        'product_id',
        'option_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
