<?php declare(strict_types=1);

namespace App\Models\User;

use App\Models\Product\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id Унікальний ідентифікатор користувача
 * @property int $product_variant_id Унікальний ідентифікатор варіанта товару
 */
class WishlistItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_variant_id'
    ];

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
