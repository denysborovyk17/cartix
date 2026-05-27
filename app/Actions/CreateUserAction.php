<?php declare(strict_types=1);

namespace App\Actions;

use App\DTO\CreateUserData;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function __construct(
        //
    ) {
    }

    public function handle(CreateUserData $data): User
    {
        return User::create([
            'name' => $data->getName(),
            'email' => $data->getEmail(),
            'password' => Hash::make($data->getPassword()),
        ]);
    }
}
