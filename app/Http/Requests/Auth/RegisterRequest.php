<?php declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'bail|required|unique:users|string|email|max:255',
            'password' => 'required|string|min:12',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Ім\'я обов\'язкове',
            'name.string' => 'Ім\'я має бути рядком',
            'name.max' => 'Максимальна довжина ім\'я 255 символів',
            'email.required' => 'Email обов\'язковий',
            'email.string' => 'Email має бути рядком',
            'email.email' => 'Email має містити @',
            'email.max' => 'Максимальна довжина Email 255 символів',
            'password.required' => 'Пароль обов\'язковий',
            'password.string' => 'Пароль має бути рядком',
            'password.min' => 'Мінімальна довжина пароля 12 символів',
        ];
    }
}
