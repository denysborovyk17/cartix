<?php declare(strict_types=1);

namespace App\Models\User;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property int $product_variant_id
 */
class WishlistItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_variant_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
