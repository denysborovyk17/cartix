<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @property Collection<int, CartItem> $items */
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

    public function findItem(int $productVariantId): CartItem|null
    {
        return $this->items()
            ->where('product_variant_id', $productVariantId)
            ->first();
    }
}
