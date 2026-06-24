<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\OptionValue;
use Illuminate\Pagination\LengthAwarePaginator;

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
}
