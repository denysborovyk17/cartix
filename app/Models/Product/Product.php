<?php declare(strict_types=1);

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int|null $category_id Унікальний ідентифікатор категорії
 * @property int|null $brand_id Унікальний ідентифікатор бренду
 * @property string $name Назва товару
 * @property string $slug Унікальний слаг товару
 * @property string|null $description Опис товару
 * @property string|null $image Картинка товару
 * @property bool is_active Статус, чи товар активний
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'product_options');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
