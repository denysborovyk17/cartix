<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository
    ) {
    }

    public function show(string $slug): View
    {
        $product = $this->productRepository->findProductBySlug($slug);
        $relatedProducts = $this->productRepository->findRelatedProductBySlug($slug);

        return view('product', compact('product', 'relatedProducts'));
    }
}
