<?php declare(strict_types=1);

namespace App\Actions\Profile;

use App\Data\UpdatePasswordData;
use App\Models\User\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

readonly class UpdatePasswordAction
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function handle(UpdatePasswordData $data, int $userId): User
    {
        $user = $this->userRepository->findById($userId);

        $user->update([
            'password' => Hash::make($data->getPassword()),
        ]);

        return $user;
    }
}
