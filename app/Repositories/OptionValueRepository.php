<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product\OptionValue;

readonly class OptionValueRepository
{
    public function __construct(
        //
    ) {
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
