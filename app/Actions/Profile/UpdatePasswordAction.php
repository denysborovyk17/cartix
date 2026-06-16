<?php declare(strict_types=1);

namespace App\Actions\Profile;

use App\Data\UpdatePasswordData;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;

readonly class UpdatePasswordAction
{
    public function __construct(
        //
    ) {
    }

    public function handle(UpdatePasswordData $data): User
    {
        $user = auth()->user();

        $user->update([
            'password' => Hash::make($data->getPassword()),
        ]);

        return $user;
    }
}
