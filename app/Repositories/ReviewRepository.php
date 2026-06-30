<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Review;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class ReviewRepository
{
    public function findById(int $reviewId): Review
    {
        return Review::query()->findOrFail($reviewId);
    }

    public function getAll(): LengthAwarePaginator
    {
        return Review::query()->paginate(config('custom.pagination.per_page'));
    }

    public function getForProduct(int $productId): LengthAwarePaginator
    {
        return Review::query()
            ->where('product_id', $productId)
            ->latest()
            ->paginate(config('custom.pagination.per_page'));
    }
}
