<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Data\UpdateProfileData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Date;

class UpdateProfileRequest extends FormRequest
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
            'avatar_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'phone' => ['nullable', 'phone:UA'],
            'birthday' => ['nullable', (new Date())->format('Y-m-d')->beforeOrEqual('today')],
            'remove_avatar_path' => ['sometimes', 'boolean']
        ];
    }

    public function getData(): UpdateProfileData
    {
        return UpdateProfileData::fromArray($this->validated());
    }
}
