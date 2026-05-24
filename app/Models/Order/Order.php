<?php declare(strict_types=1);

namespace App\Models\Order;

use App\Enums\OrderStatus;
use App\Models\Payment\Payment;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null $user_id Унікальний ідентифікатор користувача
 * @property OrderStatus $status Статус на якому перебуває замовлення
 * @property int $total Загальна сума замовлення
 * @property string $name Ім'я покупця
 * @property string $email Електонна адреса покупця
 * @property string $phone Номер телефону покупця
 * @property string $city Місто прибуття товару
 * @property string $address Адреса прибуття товару
 * @property string|null $notes Коментарі до замовлення
 */
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total',
        'name',
        'email',
        'phone',
        'city',
        'address',
        'notes'
    ];

    protected $attributes = [
        'status' => 'pending'
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
