<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[Fillable([
    'name',
    'slug'
])]
class Category extends Model
{
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
