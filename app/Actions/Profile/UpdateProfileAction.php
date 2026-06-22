<?php declare(strict_types=1);

namespace App\Actions\Profile;

use App\Data\UpdateProfileData;
use App\Models\User\User;
use App\Repositories\UserRepository;
use App\Services\FileService;

readonly class UpdateProfileAction
{
    public function __construct(
        private UserRepository $userRepository,
        private FileService $fileService
    ) {
    }

    public function handle(UpdateProfileData $data, int $userId): User
    {
        $user = $this->userRepository->findById($userId);

        $avatarPath = $this->fileService->update($data->getRemoveAvatarPath(), $data->getAvatarPath(), $user->avatar_path);

        $user->update([
            'name' => $data->getName(),
            'avatar_path' => $avatarPath,
            'phone' => $data->getPhone(),
            'birthday' => $data->getBirthday()
        ]);

        return $user;
    }
}
