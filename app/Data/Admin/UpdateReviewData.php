<?php declare(strict_types=1);

namespace App\Data\Admin;

readonly class UpdateReviewData
{
    public function __construct(
        private string|null $comment
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            comment: $data['comment']
        );
    }

    public function getComment(): string|null
    {
        return $this->comment;
    }
}
