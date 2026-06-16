<?php declare(strict_types=1);

namespace App\Data;

readonly class ConfirmPaymentData
{
    public function __construct(
        private string $cardLast4,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            cardLast4: $data['card_last4']
        );
    }

    public function getLastCard4(): string
    {
        return $this->cardLast4;
    }
}
