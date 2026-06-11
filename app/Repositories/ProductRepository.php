<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\ProductSearchFilterData;
use Illuminate\Support\Facades\DB;
use App\Models\Product\{Product, Brand, OptionValue};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ProductRepository
{
    public function findBySlug(string $slug): Product
    {
        return Product::query()
            ->active()
            ->with('variants.optionValues')
            ->where('slug', $slug)
            ->withCount(array_merge(['reviews as total_reviews'], $this->getRatings()))
            ->withAvg('reviews as avg_rating', 'rating')
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

    public function getBrands(): Collection
    {
        return Brand::query()->get();
    }

    public function getColors(): array
    {
        return OptionValue::query()
            ->whereHas('option', fn($q) => $q->where('name', 'Color'))
            ->pluck('value')
            ->toArray();
    }

    public function getSizes(): array
    {
        return OptionValue::query()
            ->whereHas('option', fn($q) => $q->where('name', 'Size'))
            ->pluck('value')
            ->toArray();
    }

    public function findBySearchAndFilter(ProductSearchFilterData $data, int $categoryId): LengthAwarePaginator
    {
        return Product::query()
            ->with('variants.optionValues')
            ->where('category_id', $categoryId)

            ->when($data->getSearch(),
                fn($q) => $q->where(
                    fn($q) => $q->whereLike('name', "%{$data->getSearch()}%")
                        ->orWhereLike('description', "%{$data->getSearch()}%")
                )
            )

            ->when($data->getBrands(),
                fn($q) => $q->whereIn('brand_id', $data->getBrands()
                )
            )

            ->when($data->getMinPrice() || $data->getMaxPrice(),
                fn($q) => $q->whereHas('variants',
                    fn($q) => $q->whereBetween('price', [$data->getMinPrice() ?? 0, $data->getMaxPrice() ?? 99999999])
                )
            )

            ->when($data->getSortByPrice(), function ($query, $sortByPrice) {
                $subQuery = DB::table('product_variants')
                    ->select(DB::raw('COALESCE(discount_price, price)'))
                    ->whereColumn('product_id', 'products.id')
                    ->orderBy(DB::raw('COALESCE(price, discount_price)'), $sortByPrice)
                    ->limit(1);

                return $query->orderBy($subQuery, $sortByPrice);
            })

            ->when($data->getSizes(),
                fn($q) => $q->whereHas('variants.optionValues',
                    fn($q) => $q->whereIn('value', $data->getSizes())
                )
            )
            ->paginate($data->getPerPage())
            ->withQueryString();
    }

    private function getRatings(): array
    {
        $numbers = range(1, 5);

        $counts = [];
        foreach ($numbers as $number) {
            $counts["reviews as stars_$number"] = fn($q) => $q->where('rating', $number);
        }

        return $counts;
    }
}
