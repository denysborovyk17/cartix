<?php declare(strict_types=1);

namespace App\Actions\Admin\Review;

use App\Repositories\ReviewRepository;

readonly class DeleteReviewAction
{
    public function __construct(
        private ReviewRepository $reviewRepository
    ) {
    }

    public function handle(int $reviewId): void
    {
        $review = $this->reviewRepository->findById($reviewId);

        $review->delete();
    }
}
