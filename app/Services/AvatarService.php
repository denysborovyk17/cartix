<?php declare(strict_types=1);

namespace App\Services;

use App\Data\UpdateProfileData;
use Illuminate\Support\Facades\Storage;

readonly class AvatarService
{
    public function __construct(
        //
    ) {
    }

    public function updateForUser(UpdateProfileData $data, ?string $currentAvatarPath): string|null
    {
        $avatarPath = $currentAvatarPath;

        if ($data->getRemoveAvatarPath() && $avatarPath) {
            Storage::disk('public')->delete($avatarPath);
            $avatarPath = null;
        }

        if ($data->getAvatarPath()) {
            if ($avatarPath) {
                Storage::disk('public')->delete($avatarPath);
            }
            $avatarPath = $data->getAvatarPath()->store('avatars', 'public');
        }

        return $avatarPath;
    }
}
