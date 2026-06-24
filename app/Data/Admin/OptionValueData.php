<?php declare(strict_types=1);

namespace App\Data\Admin;

readonly class OptionValueData
{
    public function __construct(
        private string $optionName,
        private string $value
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            optionName: $data['option_name'],
            value: $data['value']
        );
    }

    public function getOptionName(): string
    {
        return $this->optionName;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
