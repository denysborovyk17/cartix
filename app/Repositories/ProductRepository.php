<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function findProductBySlug(string $slug): Product
    {
        $product = Product::with('variants')->where('slug', $slug)->firstOrFail();

        return Product::query()
            ->with('variants')
            ->where('slug', $slug)
            ->where('category_id', $product->category_id)
            ->firstOrFail();
    }

    public function findRelatedProductBySlug(string $slug): Collection
    {
        $product = Product::with('variants')->where('slug', $slug)->firstOrFail();

        return Product::query()
            ->with('variants')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();
    }
}
