<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Category;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class CategoryRepository
{
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

    public function getCategories(): LengthAwarePaginator
    {
        return Category::query()->with('parent')->paginate(config('custom.pagination.per_page'));
    }
}
