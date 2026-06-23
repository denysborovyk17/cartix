<?php declare(strict_types=1);

namespace App\Actions\Product;

use App\Data\CreateReviewData;
use App\Models\Product\Review;
use App\Repositories\ProductRepository;

readonly class CreateReviewAction
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {}

    public function handle(CreateReviewData $data, string $productSlug, int $userId): Review
    {
        $product = $this->productRepository->findBySlug($productSlug);

        return Review::query()->updateOrCreate([
                'product_id' => $product->id,
                'user_id' => $userId,
            ],
            [
                'rating' => $data->getRating(),
                'comment' => $data->getComment()
            ]);
    }
}
