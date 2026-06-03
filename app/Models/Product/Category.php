<?php declare(strict_types=1);

namespace App\Models\Product;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id Унікальний ідентифікатор категорії
 * @property string $name Назва категорії
 * @property string $slug Унікальний слаг категорії
 * @property int|null $parent_id Унікальний ідентифікатор батьківської категорії
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

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
