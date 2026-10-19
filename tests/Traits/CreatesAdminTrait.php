<?php declare(strict_types=1);

namespace Tests\Traits;

use App\Enums\UserRole;
use App\Models\User\User;

trait CreatesAdminTrait
{
    public function asAdmin(): User
    {
        return User::factory()->create([
            'role' => UserRole::ADMIN
        ]);
    }
}
