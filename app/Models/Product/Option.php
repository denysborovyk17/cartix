<?php declare(strict_types=1);

namespace App\Models\Product;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id Унікальний ідентифікатор опції
 * @property string $name Назва опції товару
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
 */
class Option extends Model
{
    protected $fillable = [
        'name'
    ];

    public function values(): HasMany
    {
        return $this->hasMany(OptionValue::class);
    }
}
