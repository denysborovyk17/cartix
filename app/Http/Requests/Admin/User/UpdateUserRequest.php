<?php declare(strict_types=1);

namespace App\Http\Requests\Admin\User;

use App\Data\Admin\UserData;
use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['bail', 'required', Rule::unique('users', 'email')->ignore($this->user), 'string', 'email', 'max:255'],
            'password' => ['nullable', 'string', 'min:12', 'confirmed'],
            'avatar_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'phone' => ['nullable', 'phone:UA'],
            'birthday' => ['nullable', 'before_or_equal:today'],
            'role' => ['required', new Enum(UserRole::class)],
            'remove_avatar_path' => ['sometimes', 'boolean']
        ];
    }

    public function getData(): UserData
    {
        return UserData::fromArray($this->validated());
    }
}
