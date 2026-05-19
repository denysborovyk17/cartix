<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function findBySlug(string $slug): Product
    {
        return Product::query()
            ->with('variants')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function findRelatedBySlug(string $slug): Collection
    {
        $product = $this->findBySlug($slug);

        return Product::query()
            ->with('variants')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();
    }
}
