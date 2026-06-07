<?php declare(strict_types=1);

namespace App\DTO;

use Propaganistas\LaravelPhone\PhoneNumber;

readonly class CreateOrderData
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $email,
        private PhoneNumber $phone,
        private string $city,
        private string $address,
        private string $notes
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            email: $data['email'],
            phone: new PhoneNumber($data['phone']),
            city: $data['city'],
            address: $data['address'],
            notes: $data['notes']
        );
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): PhoneNumber
    {
        return $this->phone;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }
}
