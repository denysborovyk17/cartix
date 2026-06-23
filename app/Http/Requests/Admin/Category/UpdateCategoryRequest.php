<?php declare(strict_types=1);

namespace App\Http\Requests\Admin\Category;

use App\Data\Admin\CategoryData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'parent' => ['nullable', 'string', 'exists:categories,name']
        ];
    }

    public function getData(): CategoryData
    {
        return CategoryData::fromArray($this->validated());
    }
}
