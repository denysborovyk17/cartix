<?php declare(strict_types=1);

namespace App\Data\Admin;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\UploadedFile;
use Propaganistas\LaravelPhone\PhoneNumber;

readonly class UserData
{
    public function __construct(
        private string $name,
        private string $email,
        private string|null $password,
        private UploadedFile|null $avatarPath,
        private PhoneNumber|null $phone,
        private CarbonInterface|null $birthday,
        private string $role,
        private bool $removeAvatarPath
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null,
            avatarPath: $data['avatar_path'] ?? null,
            phone: !empty($data['phone']) ? new PhoneNumber($data['phone'], 'UA') : null,
            birthday: !empty($data['birthday']) ? Carbon::parse($data['birthday']) : null,
            role: $data['role'],
            removeAvatarPath: !empty($data['remove_avatar_path'])
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function getAvatarPath(): UploadedFile|null
    {
        return $this->avatarPath;
    }

    public function getPhone(): PhoneNumber|null
    {
        return $this->phone;
    }

    public function getBirthday(): CarbonInterface|null
    {
        return $this->birthday;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getRemoveAvatarPath(): bool
    {
        return $this->removeAvatarPath;
    }
}
