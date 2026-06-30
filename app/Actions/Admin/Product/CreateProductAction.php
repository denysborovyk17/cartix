<?php declare(strict_types=1);

namespace App\Actions\Admin\Product;

use App\Data\Admin\ProductData;
use App\Models\Product\{Product, ProductVariant};
use App\Repositories\{CategoryRepository, BrandRepository, OptionRepository, OptionValueRepository};
use App\Services\{SlugService, FileService};
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class CreateProductAction
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private BrandRepository $brandRepository,
        private SlugService $slugService,
        private FileService $fileService,
        private OptionRepository $optionRepository,
        private OptionValueRepository $optionValueRepository
    ) {
    }

    /**
     * @throws Throwable
     */
    public function handle(ProductData $data): Product
    {
        return DB::transaction(function () use ($data): Product {
            $category = $this->categoryRepository->findByName($data->getCategory());
            $brand = $this->brandRepository->findByName($data->getBrand());
            $slug = $this->slugService->generateUnique($data->getName() ?? $data->getExistingProductName(), new Product());
            $image = $this->fileService->update($data->getRemoveImage(), $data->getImage());

            $product = Product::create([
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'name' => $data->getName() ?? $data->getExistingProductName(),
                'slug' => $slug,
                'description' => $data->getDescription(),
                'image' => $image,
                'is_active' => $data->getIsActive()
            ]);

            $arrayOfOptionIds = $this->optionRepository->findIdsByNames($data->getOptions());

            $product->options()->sync($arrayOfOptionIds);

            $productVariant = ProductVariant::create([
                'product_id' => $product->id,
                'price' => $data->getPrice(),
                'discount_price' => $data->getDiscountPrice() ?? null,
                'currency' => $data->getCurrency(),
                'stock' => $data->getStock()
            ]);

            $arrayOfOptionValueIds = $this->optionValueRepository->findIdsByValues($data->getOptionValues());

            $productVariant->optionValues()->sync($arrayOfOptionValueIds);

            return $product;
        });
    }
}
