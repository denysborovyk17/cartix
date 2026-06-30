<?php declare(strict_types=1);

namespace App\Data\Admin;

use Propaganistas\LaravelPhone\PhoneNumber;

readonly class OrderData
{
    public function __construct(
        private string $status,
        private string $firstName,
        private string $lastName,
        private string $email,
        private PhoneNumber $phone,
        private string $city,
        private string $address,
        private string|null $notes,
        private array $productVariantIds
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'],
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            email: $data['email'],
            phone: new PhoneNumber($data['phone'], 'UA'),
            city: $data['city'],
            address: $data['address'],
            notes: $data['notes'],
            productVariantIds: $data['product_variant_ids'],
        );
    }

    public function getStatus(): string
    {
        return $this->status;
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

    public function getNotes(): string|null
    {
        return $this->notes;
    }

    public function getProductVariantIds(): array
    {
        return $this->productVariantIds;
    }
}
