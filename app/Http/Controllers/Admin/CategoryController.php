<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Category\{CreateCategoryAction, UpdateCategoryAction, DeleteCategoryAction};
use App\Http\Requests\Admin\Category\{StoreCategoryRequest, UpdateCategoryRequest};
use App\Repositories\CategoryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final readonly class CategoryController
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
    }

    public function index(): View
    {
        $categories = $this->categoryRepository->getCategories();

        return view('sbadmin2.tables.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('sbadmin2.tables.categories.create');
    }

    public function store(StoreCategoryRequest $request, CreateCategoryAction $action): RedirectResponse
    {
        $action->handle($request->getData());

        return redirect()->back();
    }

    public function edit(int $categoryId): View
    {
        $category = $this->categoryRepository->findById($categoryId);

        return view('sbadmin2.tables.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, UpdateCategoryAction $action, int $categoryId): RedirectResponse
    {
        $action->handle($request->getData(), $categoryId);

        return redirect()->back();
    }

    public function destroy(DeleteCategoryAction $action, int $categoryId): RedirectResponse
    {
        $action->handle($categoryId);

        return redirect()->back();
    }
}
