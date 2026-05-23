<?php declare(strict_types=1);

namespace App\Models\Payment;

use App\Enums\PaymentStatus;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $order_id
 * @property int $amount
 * @property PaymentStatus $status
 * @property string $card_last4
 * @property string $gateway
 * @property string $gateway_transaction_id
 * @property array $payload
 */
class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'status',
        'card_last4',
        'gateway',
        'gateway_transaction_id',
        'payload'
    ];

    protected $attributes = [
        'status' => 'pending',
        'payload' => 'array'
    ];

    protected function casts(): array
    {
        return [
            'status' => PaymentStatus::class
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
