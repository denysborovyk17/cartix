<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\User\User;

readonly class UserRepository
{
    public function findById(int $userId): User
    {
        return User::query()->findOrFail($userId);
    }
}
