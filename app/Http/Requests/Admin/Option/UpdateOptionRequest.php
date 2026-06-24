<?php declare(strict_types=1);

namespace App\Http\Requests\Admin\Option;

use App\Data\Admin\OptionData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOptionRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50']
        ];
    }

    public function getData(): OptionData
    {
        return OptionData::fromArray($this->validated());
    }
}
