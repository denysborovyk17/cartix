<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\OptionValue;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class OptionValueRepository
{
    public function __construct(
        //
    ) {
    }

    public function getAll(): LengthAwarePaginator
    {
        return OptionValue::query()->with('option')->paginate(config('custom.pagination.per_page'));
    }

    public function getAllCollection(): Collection
    {
        return OptionValue::query()->get();
    }

    public function findById(int $optionValueId): OptionValue
    {
        return OptionValue::query()->findOrFail($optionValueId);
    }

    public function getColors(): array
    {
        return OptionValue::query()
            ->whereHas('option', fn($q) => $q->where('name', 'Color'))
            ->pluck('value')
            ->toArray();
    }

    public function getSizes(): array
    {
        return OptionValue::query()
            ->whereHas('option', fn($q) => $q->where('name', 'Size'))
            ->pluck('value')
            ->toArray();
    }

    public function findIdsByValues(array $values): array
    {
        return OptionValue::query()->whereIn('value', $values)->pluck('id')->toArray();
    }
}
