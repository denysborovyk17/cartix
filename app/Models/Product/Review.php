<?php declare(strict_types=1);

namespace App\Models\Product;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id
 * @property int $product_id
 * @property int $rating
 * @property string|null $comment
 */
class Review extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment'
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
