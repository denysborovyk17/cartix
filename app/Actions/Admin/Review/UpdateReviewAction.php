<?php declare(strict_types=1);

namespace App\Actions\Admin\Review;

use App\Data\Admin\UpdateReviewData;
use App\Models\Product\Review;
use App\Repositories\ReviewRepository;

readonly class UpdateReviewAction
{
    public function __construct(
        private ReviewRepository $reviewRepository
    ) {
    }

    public function handle(UpdateReviewData $data, int $reviewId): Review
    {
        $review = $this->reviewRepository->findById($reviewId);

        $review->update([
            'user_id' => $review->user_id,
            'product_id' => $review->product_id,
            'rating' => $review->rating,
            'comment' => $data->getComment()
        ]);

        return $review;
    }
}
