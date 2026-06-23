<?php declare(strict_types=1);

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

readonly class SlugService
{
    public function __construct(
        //
    ) {
    }

    public function generateUnique(string $name, Model $model, ?int $id = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while ($model->newQuery()->where('slug', $slug)->when($id, fn($q) => $q->whereNot('id', $id))->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }
}
