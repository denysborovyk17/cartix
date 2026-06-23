<?php declare(strict_types=1);

namespace App\Actions\Admin\Category;

use App\Repositories\CategoryRepository;

readonly class DeleteCategoryAction
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
    }

    public function handle(int $categoryId): void
    {
        $category = $this->categoryRepository->findById($categoryId);

        $category->delete();
    }
}
