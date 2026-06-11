<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\{ProductRepository, ReviewRepository};
use Illuminate\Http\Request;
use Illuminate\View\View;

readonly class ProductController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ReviewRepository $reviewRepository
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

        $reviews = $this->reviewRepository->getForProduct($product->id);

        return view('product', compact('product', 'relatedProducts', 'selectedVariant', 'reviews'));
    }
}
