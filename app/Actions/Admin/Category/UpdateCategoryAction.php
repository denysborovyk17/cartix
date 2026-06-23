<?php declare(strict_types=1);

namespace App\Actions\Admin\Category;

use App\Data\Admin\CategoryData;
use App\Models\Product\Category;
use App\Repositories\CategoryRepository;
use App\Services\SlugService;

readonly class UpdateCategoryAction
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private SlugService $slugService
    ) {
    }

    public function handle(CategoryData $data, int $categoryId): Category
    {
        $category = $this->categoryRepository->findById($categoryId);
        $parent = $this->categoryRepository->findByParentName($data->getParent());

        if ($category->id === $parent->id) {
            $parent->id = null;
        }

        $category->update([
            'name' => $data->getName(),
            'slug' => $this->slugService->generateUnique($data->getName(), new Category(), $category->id),
            'parent_id' => $parent->id
        ]);

        return $category;
    }
}
