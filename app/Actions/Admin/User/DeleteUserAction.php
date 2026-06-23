<?php declare(strict_types=1);

namespace App\Actions\Admin\User;

use App\Repositories\UserRepository;

readonly class DeleteUserAction
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function handle(int $userId): void
    {
        $user = $this->userRepository->findById($userId);

        $user->delete();
    }
}
