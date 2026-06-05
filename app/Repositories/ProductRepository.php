<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function findBySlug(string $slug): Product
    {
        return Product::query()
            ->with('variants.optionValues')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function findRelatedBySlug(string $slug): Collection
    {
        $product = $this->findBySlug($slug);

        return Product::query()
            ->with('variants.optionValues')
            ->where('category_id', $product->category_id)
            ->whereNot('id', $product->id)
            ->latest()
            ->take(4)
            ->get();
    }

    public function findBySearch(string $search, int $categoryId): LengthAwarePaginator
    {
        return Product::search($search)->query(function ($query) {
            $query->with('variants');
        })
            ->where('category_id', $categoryId)
            ->paginate(12)
            ->withQueryString();
    }
}
