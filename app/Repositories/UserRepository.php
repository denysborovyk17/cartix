<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\User\User;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class UserRepository
{
    public function findById(int $userId): User
    {
        return User::query()->findOrFail($userId);
    }

    public function getUsers(): LengthAwarePaginator
    {
        return User::query()->paginate(config('custom.pagination.per_page'));
    }
}
