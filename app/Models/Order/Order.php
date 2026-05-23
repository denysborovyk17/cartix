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
 * @property int|null $user_id
 * @property OrderStatus $status
 * @property int $total
 * @property string $name
 * @property string $email
 * @property int $phone
 * @property string $city
 * @property string $address
 * @property string|null $notes
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
