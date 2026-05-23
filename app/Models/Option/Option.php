<?php declare(strict_types=1);

namespace App\Models\Option;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
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
