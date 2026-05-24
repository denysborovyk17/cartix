<?php declare(strict_types=1);

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property string $name Назва категорії
 * @property string $slug Унікальний слаг категорії
 * @property int|null $parent_id Унікальний ідентифікатор батьківської категорії
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id'
    ];

    public function productVariants(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductVariant::class,
            Product::class,
            'category_id',
            'product_id',
            'id',
            'id'
        );
    }
}
