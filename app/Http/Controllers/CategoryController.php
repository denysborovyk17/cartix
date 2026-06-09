<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\DTO\ProductSearchFilterData;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly ProductRepository $productRepository
    ) {
    }

    public function show(Request $request, string $slug): View
    {
        $category = $this->categoryRepository->findBySlug($slug);

        $products = $this->productRepository->findBySearchAndFilter(new ProductSearchFilterData(
            search: $request->input('search'),
            minPrice: (int) $request->input('min_price'),
            maxPrice: (int) $request->input('max_price'),
            brands: $request->input('brands'),
            colors: $request->input('colors'),
            sizes: $request->input('sizes'),
            perPage: config('custom.pagination.per_page')
        ), $category->id);

        $brands = $this->productRepository->getBrands();
        $colors = $this->productRepository->getColors();
        $sizes = $this->productRepository->getSizes();

        return view('category', compact('category', 'products', 'brands', 'colors', 'sizes'));
    }
}
