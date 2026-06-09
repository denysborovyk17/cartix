<?php declare(strict_types=1);

namespace App\DTO;

readonly class ProductSearchFilterData
{
    public function __construct(
        private ?string $search,
        private ?int $minPrice,
        private ?int $maxPrice,
        private ?array $brands,
        private ?array $colors,
        private ?array $sizes,
        private int $perPage
    ) {
    }

    public function getSearch(): string|null
    {
        return $this->search;
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
