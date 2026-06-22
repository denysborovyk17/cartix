<?php declare(strict_types=1);

namespace App\Models\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Models\Cart\Cart;
use App\Models\Order\Order;
use App\Models\Product\ProductVariant;
use App\Models\Product\Review;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsToMany, HasMany, HasOne};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

/**
 * @property int $id Унікальний ідентифікатор користувача
 * @property string $name Ім'я користувача
 * @property string $email Електронна адреса користувача
 * @property string $password Пароль користувача
 * @property string|null $avatar_path Аватар користувача
 * @property string|null $avatar_path_url Аватар користувача (URL)
 * @property string|null $phone Номер телефону користувача
 * @property CarbonInterface|null $birthday День народження користувача
 * @property CarbonInterface|null $created_at Дата створення запису
 * @property CarbonInterface|null $updated_at Дата оновлення запису
 * @property UserRole $role Роль користувача
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
        'phone',
        'birthday',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'role'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone' => E164PhoneNumberCast::class . ':UA',
            'birthday' => 'date',
            'role' => UserRole::class
        ];
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlistItems(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'wishlist_items')
            ->withPivot('id')
            ->withTimestamps();
    }

    public function getAvatarPathUrlAttribute(): string|null
    {
        return $this->avatar_path ? asset('storage/' . $this->avatar_path) : null;
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }
}
