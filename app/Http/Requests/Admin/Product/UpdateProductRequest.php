<?php declare(strict_types=1);

namespace App\Http\Requests\Admin\Product;

use App\Data\Admin\ProductData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'category' => ['required', 'string', 'exists:categories,name'],
            'brand' => ['required', 'string', 'exists:brands,name'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'min:20'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active' => ['sometimes', 'boolean'],
            'existing_name' => ['nullable', 'string', 'exists:products,name'],
            'price' => ['required', 'integer'],
            'discount_price' => ['nullable', 'int'],
            'currency' => ['required', 'string', 'in:UAH,USD,EUR'],
            'stock' => ['required', 'int'],
            'options' => ['nullable', 'array', 'exists:options,name'],
            'option_values' => ['nullable', 'array', 'exists:option_values,value'],
            'remove_image' => ['nullable', 'boolean']
        ];
    }

    public function getData(): ProductData
    {
        return ProductData::fromArray($this->validated());
    }
}
