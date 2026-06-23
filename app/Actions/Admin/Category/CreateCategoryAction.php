<?php declare(strict_types=1);

namespace App\Actions\Admin\Category;

use App\Data\Admin\CategoryData;
use App\Models\Product\Category;
use App\Repositories\CategoryRepository;
use App\Services\SlugService;

readonly class CreateCategoryAction
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private SlugService $slugService
    ) {
    }

    public function handle(CategoryData $data): Category
    {
        $parent = $this->categoryRepository->findByParentName($data->getParent());

        return Category::create([
            'name' => $data->getName(),
            'slug' => $this->slugService->generateUnique($data->getName(), new Category()),
            'parent_id' => $parent->id ?? null
        ]);
    }
}
