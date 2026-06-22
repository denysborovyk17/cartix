<?php declare(strict_types=1);

namespace App\Actions\Admin\Brand;

use App\Data\Admin\BrandData;
use App\Models\Product\Brand;
use App\Repositories\BrandRepository;
use App\Services\FileService;

readonly class UpdateBrandAction
{
    public function __construct(
        private BrandRepository $brandRepository,
        private FileService $fileService
    ) {
    }

    public function handle(BrandData $data, int $brandId): Brand
    {
        $brand = $this->brandRepository->findById($brandId);

        $imagePath = $this->fileService->update($data->getRemoveImage(), $data->getImage(), $brand->image);

        $brand->update([
            'name' => $data->getName(),
            'image' => $imagePath
        ]);

        return $brand;
    }
}
