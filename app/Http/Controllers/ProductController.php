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

    public function show(Request $request, string $slug): View
    {
        $product = $this->productRepository->findBySlug($slug);
        $relatedProducts = $this->productRepository->findRelatedBySlug($slug);
        $productVariantId = $request->query('variant');

        if ($productVariantId) {
            $selectedVariant = $product->variants()->findOrFail($productVariantId);
        } else {
            $selectedVariant = $product->variants()->first();
        }

        return view('product', compact('product', 'relatedProducts', 'selectedVariant'));
    }
}
