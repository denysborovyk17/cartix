<?php declare(strict_types=1);

namespace App\Data;

readonly class CreateReviewData
{
    public function __construct(
        private int $rating,
        private string $comment,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            rating: (int) $data['rating'],
            comment: $data['comment']
        );
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getComment(): string
    {
        return $this->comment;
    }
}
