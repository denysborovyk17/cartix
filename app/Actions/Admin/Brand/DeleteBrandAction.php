<?php declare(strict_types=1);

namespace App\Actions\Admin\Brand;

use App\Repositories\BrandRepository;

readonly class DeleteBrandAction
{
    public function __construct(
        private BrandRepository $brandRepository
    ) {
    }

    public function handle(int $brandId): void
    {
        $brand = $this->brandRepository->findById($brandId);

        $brand->delete();
    }
}
