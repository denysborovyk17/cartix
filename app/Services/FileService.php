<?php declare(strict_types=1);

namespace App\Services;

use App\Data\UpdateProfileData;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

readonly class FileService
{
    public function __construct(
        //
    ) {
    }

    public function update(bool $removeFile, ?UploadedFile $file, ?string $currentFile = null): string|null
    {
        if ($removeFile && $currentFile) {
            Storage::disk('public')->delete($currentFile);
            $currentFile = null;
        }

        if ($file) {
            if ($currentFile) {
                Storage::disk('public')->delete($currentFile);
            }
            $currentFile = $file->store('avatars', 'public');
        }

        return $currentFile;
    }
}
