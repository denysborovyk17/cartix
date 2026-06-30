<?php declare(strict_types=1);

namespace App\Http\Requests\Admin\Order;

use App\Data\Admin\OrderData;
use App\Enums\OrderStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreOrderRequest extends FormRequest
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
            'status' => ['required', new Enum(OrderStatus::class)],
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'phone:UA'],
            'city' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
            'product_variant_ids' => ['required', 'array'],
        ];
    }

    public function getData(): OrderData
    {
        return OrderData::fromArray($this->validated());
    }
}
