<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function show(string $slug): View
    {
        $category = Category::with('productVariants')->where('slug', $slug)->firstOrFail();

        return view('category', compact('category'));
    }
}
