<?php declare(strict_types=1);

namespace App\Services;

readonly class FakePaymentGatewayService
{
    public function __construct(
        //
    ) {
    }

    public function emulation(): bool
    {
        $chance = rand(0, 100);

        if ($chance >= 15) {
            return true;
        } else {
            return false;
        }
    }
}
