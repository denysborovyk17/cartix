<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepository $categoryRepository
    ) {
    }

    public function show(string $slug): View
    {
        $category = $this->categoryRepository->getBySlug($slug);

        return view('category', compact('category'));
    }
}
