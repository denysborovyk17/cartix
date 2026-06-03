<?php declare(strict_types=1);

namespace App\Models\Payment;

use App\Enums\PaymentStatus;
use App\Models\Order\Order;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id Унікальний ідентифікатор платежу
 * @property int $order_id Унікальний ідентифікатор замовлення
 * @property int $amount Фінальна сума замовлення до оплати
 * @property PaymentStatus $status Статус на якому перебуває оплата
 * @property string $card_last4 Останні 4 цифри платіжної карти покупця
 * @property string $gateway Спосіб оплати
 * @property string $gateway_transaction_id Унікальний ідентифікатор оплати
 * @property array $payload Інформація про замовлення та оплату
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
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
        'payload' => '[]'
    ];

    protected function casts(): array
    {
        return [
            'status' => PaymentStatus::class,
            'payload' => 'array'
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
