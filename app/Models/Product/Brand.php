<?php declare(strict_types=1);

namespace App\Models\Product;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id Унікальний ідентифікатор бренду
 * @property string $name Назва бренду
 * @property string $slug Унікальний слаг бренду
 * @property string|null $image Картинка бренду
 * @property string|null $image_url Картинка бренду (URL)
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
 */
class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function getImageUrlAttribute(): string|null
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
