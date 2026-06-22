<?php declare(strict_types=1);

namespace App\Actions\Admin\Brand;

use App\Data\Admin\BrandData;
use App\Models\Product\Brand;
use App\Services\SlugService;

readonly class CreateBrandAction
{
    public function __construct(
        private SlugService $slugService
    ) {
    }

    public function handle(BrandData $data): Brand
    {
        return Brand::create([
            'name' => $data->getName(),
            'slug' => $this->slugService->generateUnique($data->getName(), new Brand()),
            'image' => $data->getImage()
        ]);
    }
}
