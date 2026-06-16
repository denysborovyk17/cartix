<?php declare(strict_types=1);

namespace App\Data;

readonly class UpdatePasswordData
{
    public function __construct(
        private string $password
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            password: $data['password']
        );
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
