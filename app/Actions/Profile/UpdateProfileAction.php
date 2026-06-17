<?php declare(strict_types=1);

namespace App\Actions\Profile;

use App\Data\UpdateProfileData;
use App\Models\User\User;
use App\Services\AvatarService;

readonly class UpdateProfileAction
{
    public function __construct(
        private AvatarService $avatarService
    ) {
    }

    public function handle(UpdateProfileData $data): User
    {
        $user = auth()->user();

        $avatarPath = $this->avatarService->updateForUser($data, $user->avatar_path);

        $user->update([
            'name' => $data->getName(),
            'avatar_path' => $avatarPath,
            'phone' => $data->getPhone(),
            'birthday' => $data->getBirthday()
        ]);

        return $user;
    }
}
