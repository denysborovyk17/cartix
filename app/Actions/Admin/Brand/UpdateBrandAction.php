<?php declare(strict_types=1);

namespace App\Actions\Admin\Brand;

use App\Data\Admin\BrandData;
use App\Models\Product\Brand;
use App\Repositories\BrandRepository;
use App\Services\{FileService, SlugService};

readonly class UpdateBrandAction
{
    public function __construct(
        private BrandRepository $brandRepository,
        private FileService $fileService,
        private SlugService $slugService
    ) {
    }

    public function handle(BrandData $data, int $brandId): Brand
    {
        $brand = $this->brandRepository->findById($brandId);
        $imagePath = $this->fileService->update($data->getRemoveImage(), $data->getImage(), $brand->image);

        $brand->update([
            'name' => $data->getName(),
            'slug' => $this->slugService->generateUnique($data->getName(), new Brand(), $brand->id) ?? $brand->slug,
            'image' => $imagePath
        ]);

        return $brand;
    }
}
