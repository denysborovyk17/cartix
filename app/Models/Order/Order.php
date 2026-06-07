<?php declare(strict_types=1);

namespace App\Models\Order;

use App\Enums\OrderStatus;
use App\Models\Payment\Payment;
use App\Models\User\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Propaganistas\LaravelPhone\Casts\RawPhoneNumberCast;

/**
 * @property int $id Унікальний ідентифікатор замовлення
 * @property int|null $user_id Унікальний ідентифікатор користувача
 * @property OrderStatus $status Статус на якому перебуває замовлення
 * @property int $total Загальна сума замовлення
 * @property string $first_name Ім'я покупця
 * @property string $last_name Прізвище покупця
 * @property string $email Електонна адреса покупця
 * @property string $phone Номер телефону покупця
 * @property string $city Місто прибуття товару
 * @property string $address Адреса прибуття товару
 * @property string|null $notes Коментарі до замовлення
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
 */
class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total',
        'first_name',
        'last_name',
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
            'status' => OrderStatus::class,
            'phone' => RawPhoneNumberCast::class . ':UA'
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
