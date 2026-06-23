<?php declare(strict_types=1);

namespace App\Http\Requests\Admin\User;

use App\Data\Admin\UserData;
use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Date;
use Illuminate\Validation\Rules\Enum;

class StoreUserRequest extends FormRequest
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
            'email' => ['bail', 'required', 'unique:users,email', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:12', 'confirmed'],
            'avatar_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'phone' => ['nullable', 'phone:UA'],
            'birthday' => ['nullable', (new Date())->format('Y-m-d')->beforeOrEqual('today')],
            'role' => ['required', new Enum(UserRole::class)]
        ];
    }

    public function getData(): UserData
    {
        return UserData::fromArray($this->validated());
    }
}
