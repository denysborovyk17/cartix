<?php declare(strict_types=1);

namespace App\Actions\Profile;

use App\Data\UpdateProfileData;
use App\Models\User\User;
use Illuminate\Support\Facades\Storage;

readonly class UpdateProfileAction
{
    public function __construct(
        //
    ) {
    }

    public function handle(UpdateProfileData $data): User
    {
        $user = auth()->user();

        if ($data->getRemoveAvatarPath() && $user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->avatar_path = null;
        }

        if ($data->getAvatarPath()) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $user->avatar_path = $data->getAvatarPath()->store('avatars', 'public');
        }

        $user->update([
            'name' => $data->getName(),
            'avatar_path' => $user->avatar_path,
            'phone' => $data->getPhone(),
            'birthday' => $data->getBirthday()
        ]);

        return $user;
    }
}
