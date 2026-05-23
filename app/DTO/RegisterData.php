<?php declare(strict_types=1);

namespace App\DTO;

readonly class RegisterData
{
    public function __construct(
        private string $name,
        private string $email,
        private string $password
    ) {
    }

    public static function fromArray(array $data): self
    {
        if (empty($data)) {
            // Exception
        }

        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password']
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
