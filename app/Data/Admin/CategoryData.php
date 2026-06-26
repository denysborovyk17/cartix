<?php declare(strict_types=1);

namespace App\Data\Admin;

readonly class CategoryData
{
    public function __construct(
        private string $name,
        private string|null $parent
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            parent: $data['parent'] ?? null
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParent(): string|null
    {
        return $this->parent;
    }
}
