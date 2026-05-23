<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Category;

class CategoryRepository
{
    public function findBySlug(string $slug): Category
    {
        return Category::with('productVariants.product')->where('slug', $slug)->firstOrFail();
    }
}
