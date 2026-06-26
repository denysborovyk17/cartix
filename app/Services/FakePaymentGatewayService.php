<?php declare(strict_types=1);

namespace App\Services;

readonly class FakePaymentGatewayService
{
    public function __construct(
        //
    ) {
    }

    public function emulation(int $successChancePercent = 50): bool
    {
        return rand(1, 100) <= $successChancePercent;
    }
}
