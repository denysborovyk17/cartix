<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Payment\Payment;

readonly class PaymentRepository
{
    public function __construct(
        //
    ) {
    }

    public function findById(int $paymentId): Payment
    {
        return Payment::query()->findOrFail($paymentId);
    }
}
