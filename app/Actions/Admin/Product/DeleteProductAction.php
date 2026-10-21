<?php declare(strict_types=1);

namespace App\Actions\Admin\Product;

use App\Repositories\ProductRepository;

readonly class DeleteProductAction
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    public function handle(int $productVariantId): void
    {
        $productVariant = $this->productRepository->findProductVariantById($productVariantId);

        $productVariant->delete();
    }
}
