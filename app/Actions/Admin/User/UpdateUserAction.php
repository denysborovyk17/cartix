<?php declare(strict_types=1);

namespace App\Actions\Admin\User;

use App\Data\Admin\UserData;
use App\Models\User\User;
use App\Repositories\UserRepository;
use App\Services\FileService;
use Illuminate\Support\Facades\Hash;

readonly class UpdateUserAction
{
    public function __construct(
        private UserRepository $userRepository,
        private FileService $fileService
    ) {
    }

    public function handle(UserData $data, int $userId): User
    {
        $user = $this->userRepository->findById($userId);

        $avatarPath = $this->fileService->update($data->getRemoveAvatarPath(), $data->getAvatarPath(), $user->avatar_path);

        $user->update([
            'name' => $data->getName(),
            'email' => $data->getEmail(),
            'password' => $data->getPassword() ?? $user->password,
            'avatar_path' => $avatarPath,
            'phone' => $data->getPhone(),
            'birthday' => $data->getBirthday(),
            'role' => $data->getRole()
        ]);

        return $user;
    }
}
