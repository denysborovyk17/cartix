<?php declare(strict_types=1);

namespace App\Actions\User;

use App\Data\CreateUserData;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

readonly class CreateUserAction
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
