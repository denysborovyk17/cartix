<?php declare(strict_types=1);

namespace App\Models\Product;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $user_id Унікальний ідентифікатор користувача
 * @property int $product_id Унікальний ідентифікатор товару
 * @property int $rating Оцінка товару
 * @property string|null $comment Коментар користувача до товару
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
