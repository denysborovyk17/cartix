<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\ProductSearchFilterData;
use App\Repositories\{CategoryRepository, ProductRepository, BrandRepository, OptionValueRepository};
use Illuminate\Http\Request;
use Illuminate\View\View;

final readonly class CategoryController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private BrandRepository $brandRepository,
        private OptionValueRepository $optionValueRepository
    ) {
    }

    public function show(Request $request, string $slug): View
    {
        $category = $this->categoryRepository->findBySlug($slug);

        $products = $this->productRepository->findBySearchAndFilter(new ProductSearchFilterData(
            search: $request->input('search'),
            sortByPrice: $request->input('sort'),
            minPrice: (int) $request->input('min_price') * 100,
            maxPrice: (int) $request->input('max_price') * 100,
            brands: $request->input('brands'),
            colors: $request->input('colors'),
            sizes: $request->input('sizes'),
            perPage: config('custom.pagination.per_page')
        ), $category->id);

        $brands = $this->brandRepository->getAll();
        $colors = $this->optionValueRepository->getColors();
        $sizes = $this->optionValueRepository->getSizes();

        return view('category', compact('category', 'products', 'brands', 'colors', 'sizes'));
    }
}
