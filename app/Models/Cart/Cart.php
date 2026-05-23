<?php declare(strict_types=1);

namespace App\Models\Cart;

use App\Models\User\User;
use Illuminate\Database\Eloquent\{Model};
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

/**
 * @property int|null $user_id
 * @property string|null $session_id
 */
class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function findItemByProductVariantId(int $productVariantId): CartItem|null
    {
        return $this->items->where('product_variant_id', $productVariantId)->first();
    }
}
