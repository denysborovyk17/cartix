<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Brand;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class BrandRepository
{
    public function getAll(): LengthAwarePaginator
    {
        return Brand::query()->paginate(config('custom.pagination.per_page'));
    }

    public function getAllCollection(): Collection
    {
        return Brand::query()->get();
    }

    public function findById(int $brandId): Brand
    {
        return Brand::query()->findOrFail($brandId);
    }

    public function findByName(string $name): Brand
    {
        return Brand::query()->where('name', $name)->firstOrFail();
    }
}
