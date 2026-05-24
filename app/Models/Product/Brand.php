<?php declare(strict_types=1);

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name Назва бренду
 * @property string $slug Унікальний слаг бренду
 * @property string|null $image Картинка бренду
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
}
