<?php declare(strict_types=1);

namespace App\Data\Admin;

use Illuminate\Http\UploadedFile;

readonly class BrandData
{
    public function __construct(
        private string $name,
        private UploadedFile|null $image,
        private bool $removeImage
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            image: $data['image'] ?? null,
            removeImage: !empty($data['remove_image'])
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): UploadedFile|null
    {
        return $this->image;
    }

    public function getRemoveImage(): bool
    {
        return $this->removeImage;
    }
}
