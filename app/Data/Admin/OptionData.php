<?php declare(strict_types=1);

namespace App\Data\Admin;

readonly class OptionData
{
    public function __construct(
        private string $name
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name']
        );
    }

    public function getName(): string
    {
        return $this->name;
    }
}
