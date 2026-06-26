<?php declare(strict_types=1);

namespace App\Data;

readonly class ProductSearchFilterData
{
    public function __construct(
        private string|null $search,
        private string|null $sortByPrice,
        private int|null $minPrice,
        private int|null $maxPrice,
        private array|null $brands,
        private array|null $colors,
        private array|null $sizes,
        private int $perPage
    ) {
    }

    public function getSearch(): string|null
    {
        return $this->search;
    }

    public function getSortByPrice(): string|null
    {
        return $this->sortByPrice;
    }

    public function getMinPrice(): int|null
    {
        return $this->minPrice;
    }

    public function getMaxPrice(): int|null
    {
        return $this->maxPrice;
    }

    public function getBrands(): array|null
    {
        return $this->brands;
    }

    public function getColors(): array|null
    {
        return $this->colors;
    }

    public function getSizes(): array|null
    {
        return $this->sizes;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
