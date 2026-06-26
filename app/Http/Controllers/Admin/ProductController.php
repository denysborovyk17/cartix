<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Repositories\CategoryRepository;
use App\Repositories\{BrandRepository, ProductRepository, OptionRepository, OptionValueRepository};
use App\Actions\Admin\Product\{CreateProductAction, UpdateProductAction, DeleteProductAction};
use App\Http\Requests\Admin\Product\{StoreProductRequest, UpdateProductRequest};
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

final readonly class ProductController
{
    public function __construct(
        private ProductRepository $productRepository,
        private CategoryRepository $categoryRepository,
        private BrandRepository $brandRepository,
        private OptionRepository $optionRepository,
        private OptionValueRepository $optionValueRepository
    ) {
    }

    public function index(): View
    {
        $productVariants = $this->productRepository->getAllProductVariants();
        $categories = $this->categoryRepository->getAllCollection();
        $brands = $this->brandRepository->getAllCollection();
        $options = $this->optionRepository->getAllCollection();
        $optionValues = $this->optionValueRepository->getAllCollection();

        return view('sbadmin2.tables.products.index', compact('productVariants', 'categories', 'brands', 'options', 'optionValues'));
    }

    public function create(): View
    {
        $categories = $this->categoryRepository->getAllCollection();
        $brands = $this->brandRepository->getAllCollection();
        $products = $this->productRepository->getAll();
        $options = $this->optionRepository->getAllCollection();
        $optionValues = $this->optionValueRepository->getAllCollection();

        return view('sbadmin2.tables.products.create', compact('categories', 'brands', 'products', 'options', 'optionValues'));
    }

    /**
     * @throws Throwable
     */
    public function store(StoreProductRequest $request, CreateProductAction $action): RedirectResponse
    {
        $action->handle($request->getData());

        return redirect()->back();
    }

    public function edit(int $productId): View
    {
        $product = $this->productRepository->findById($productId);
        $categories = $this->categoryRepository->getAllCollection();
        $brands = $this->brandRepository->getAllCollection();
        $products = $this->productRepository->getAll();
        $options = $this->optionRepository->getAllCollection();
        $optionValues = $this->optionValueRepository->getAllCollection();

        return view('sbadmin2.tables.products.edit', compact('product', 'categories', 'brands', 'products', 'options', 'optionValues'));
    }

    /**
     * @throws Throwable
     */
    public function update(UpdateProductRequest $request, UpdateProductAction $action, int $productId): RedirectResponse
    {
        $action->handle($request->getData(), $productId);

        return redirect()->back();
    }

    public function destroy(DeleteProductAction $action, int $productId): RedirectResponse
    {
        $action->handle($productId);

        return redirect()->back();
    }
}
