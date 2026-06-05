<?php declare(strict_types=1);

namespace App\Models\Product;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

/**
 * @property int $id Унікальний ідентифікатор товару
 * @property int|null $category_id Унікальний ідентифікатор категорії
 * @property int|null $brand_id Унікальний ідентифікатор бренду
 * @property string $name Назва товару
 * @property string $slug Унікальний слаг товару
 * @property string|null $description Опис товару
 * @property string|null $image Картинка товару
 * @property bool is_active Статус, чи товар активний
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
 */
class Product extends Model
{
    use HasFactory, Searchable;

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

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];
    }
}
