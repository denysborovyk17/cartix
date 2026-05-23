<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\RegisterData;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

class RegisterRepository
{
    public function register(RegisterData $data): User
    {
        return User::create([
            'name' => $data->getName(),
            'email' => $data->getEmail(),
            'password' => Hash::make($data->getPassword())
        ]);
    }
}
