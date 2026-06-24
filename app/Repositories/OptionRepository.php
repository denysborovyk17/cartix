<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Option;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class OptionRepository
{
    public function __construct(
        //
    ) {
    }

    public function getAll(): LengthAwarePaginator
    {
        return Option::query()->paginate(config('custom.pagination.per_page'));
    }

    public function findById(int $optionId): Option
    {
        return Option::query()->findOrFail($optionId);
    }

    public function findByName(string $name): Option
    {
        return Option::query()->where('name', $name)->firstOrFail();
    }
}
