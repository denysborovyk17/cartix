<?php declare(strict_types=1);

namespace App\Actions;

use App\DTO\CreateReviewData;
use App\Models\Product\Review;
use App\Repositories\ProductRepository;

readonly class CreateReviewAction
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {}

    public function handle(CreateReviewData $data, string $slug): Review
    {
        $product = $this->productRepository->findBySlug($slug);

        return Review::query()->updateOrCreate([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $data->getRating(),
                'comment' => $data->getComment()
            ]);
    }
}
