<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'status' => 'pending'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
