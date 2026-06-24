<?php declare(strict_types=1);

namespace App\Http\Requests\Admin\OptionValue;

use App\Data\Admin\OptionValueData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOptionValueRequest extends FormRequest
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
            'option_name' => ['required', 'string', 'max:50', 'exists:options,name'],
            'value' => ['required', 'string', 'max:50']
        ];
    }

    public function getData(): OptionValueData
    {
        return OptionValueData::fromArray($this->validated());
    }
}
