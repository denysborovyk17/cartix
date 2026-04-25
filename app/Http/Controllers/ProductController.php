<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $categorySlug, string $productSlug): View
    {
        $category = Category::query()->where('slug', $categorySlug)->firstOrFail();
        $product = Product::query()->where('slug', $productSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        $relatedProducts = Product::query()
            ->with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('product', compact('category', 'product', 'relatedProducts'));
    }
}
