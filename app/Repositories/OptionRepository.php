<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\Option;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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

    public function getAllCollection(): Collection
    {
        return Option::query()->get();
    }

    public function findById(int $optionId): Option
    {
        return Option::query()->findOrFail($optionId);
    }

    public function findByName(string $name): Option
    {
        return Option::query()->where('name', $name)->firstOrFail();
    }

    public function findIdsByNames(array $names): array
    {
        return Option::query()->whereIn('name', $names)->pluck('id')->toArray();
    }
}
