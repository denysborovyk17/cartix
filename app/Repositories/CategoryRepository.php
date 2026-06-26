<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class CategoryRepository
{
    public function getAll(): LengthAwarePaginator
    {
        return Category::query()->with('parent')->paginate(config('custom.pagination.per_page'));
    }

    public function getAllCollection(): Collection
    {
        return Category::query()->get();
    }

    public function findBySlug(string $slug): Category
    {
        return Category::query()->where('slug', $slug)->firstOrFail();
    }

    public function findById(int $categoryId): Category
    {
        return Category::query()->findOrFail($categoryId);
    }

    public function findByParentName(?string $parentName): Category|null
    {
        return Category::query()->where('name', $parentName)->first();
    }

    public function findByName(string $name): Category
    {
        return Category::query()->where('name', $name)->firstOrFail();
    }
}
