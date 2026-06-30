<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Review\{UpdateReviewAction, DeleteReviewAction};
use App\Http\Requests\Admin\Review\UpdateReviewRequest;
use App\Repositories\ReviewRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final readonly class ReviewController
{
    public function __construct(
        private ReviewRepository $reviewRepository
    ) {
    }

    public function index(): View
    {
        $reviews = $this->reviewRepository->getAll();

        return view('sbadmin2.tables.reviews.index', compact('reviews'));
    }

    public function edit(int $reviewId): View
    {
        $review = $this->reviewRepository->findById($reviewId);

        return view('sbadmin2.tables.reviews.edit', compact('review'));
    }

    public function update(UpdateReviewRequest $request, UpdateReviewAction $action, int $reviewId): RedirectResponse
    {
        $action->handle($request->getData(), $reviewId);

        return redirect()->back();
    }

    public function destroy(DeleteReviewAction $action, int $reviewId): RedirectResponse
    {
        $action->handle($reviewId);

        return redirect()->back();
    }
}
