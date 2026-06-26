<?php declare(strict_types=1);

namespace App\Data\Admin;

use Illuminate\Http\UploadedFile;

readonly class ProductData
{
    public function __construct(
        private string $category,
        private string $brand,
        private string|null $name,
        private string $description,
        private UploadedFile|null $image,
        private bool $isActive,
        private string|null $existingProductName,
        private int $price,
        private int|null $discountPrice,
        private string $currency,
        private int $stock,
        private array $options,
        private array $optionValues,
        private bool $removeImage
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            category: $data['category'],
            brand: $data['brand'],
            name: $data['name'],
            description: $data['description'],
            image: $data['image'] ?? null,
            isActive: !empty($data['is_active']),
            existingProductName: $data['existing_product_name'] ?? null,
            price: (int) $data['price'],
            discountPrice: $data['discount_price'] ? (int) $data['discount_price'] : null,
            currency: $data['currency'],
            stock: (int) $data['stock'],
            options: $data['options'] ?? [],
            optionValues: $data['option_values'] ?? [],
            removeImage: !empty($data['remove_image'])
        );
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): UploadedFile|null
    {
        return $this->image;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function getExistingProductName(): string|null
    {
        return $this->existingProductName;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDiscountPrice(): int|null
    {
        return $this->discountPrice;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getOptionValues(): array
    {
        return $this->optionValues;
    }

    public function getRemoveImage(): bool
    {
        return $this->removeImage;
    }
}
