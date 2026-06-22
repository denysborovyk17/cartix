<?php declare(strict_types=1);

namespace App\Services;

use App\Data\UpdateProfileData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

readonly class AvatarService
{
    public function __construct(
        //
    ) {
    }

    public function update(bool $removeAvatarPath, ?UploadedFile $avatarPath, ?string $currentAvatarPath): string|null
    {
        if ($removeAvatarPath && $currentAvatarPath) {
            Storage::disk('public')->delete($currentAvatarPath);
            $currentAvatarPath = null;
        }

        if ($avatarPath) {
            if ($currentAvatarPath) {
                Storage::disk('public')->delete($currentAvatarPath);
            }
            $currentAvatarPath = $avatarPath->store('avatars', 'public');
        }

        return $currentAvatarPath;
    }
}
