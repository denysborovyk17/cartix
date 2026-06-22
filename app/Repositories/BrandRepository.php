<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Brand;
use Illuminate\Support\Collection;

readonly class BrandRepository
{
    public function getBrands(): Collection
    {
        return Brand::query()->get();
    }

    public function findById(int $brandId): Brand
    {
        return Brand::query()->findOrFail($brandId);
    }
}
