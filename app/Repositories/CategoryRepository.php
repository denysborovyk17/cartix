<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getBySlug($slug): Category
    {
        return Category::with('productVariants.product')->where('slug', $slug)->firstOrFail();
    }
}
