<?php declare(strict_types=1);

namespace App\Actions\Admin\User;

use App\Data\Admin\UserData;
use App\Models\User\User;

readonly class CreateUserAction
{
    public function __construct(
        //
    ) {
    }

    public function handle(UserData $data): User
    {
        return User::create([
            'name' => $data->getName(),
            'email' => $data->getEmail(),
            'password' => $data->getPassword(),
            'avatar_path' => $data->getAvatarPath(),
            'phone' => $data->getPhone(),
            'birthday' => $data->getBirthday(),
            'role' => $data->getRole()
        ]);
    }
}
