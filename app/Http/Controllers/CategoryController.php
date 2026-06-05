<?php declare(strict_types=1);

namespace App\Http\Controllers;

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

        $products = $this->productRepository->findBySearch(trim((string) $request->input('search')), $category->id);

        return view('category', compact('category', 'products'));
    }
}
