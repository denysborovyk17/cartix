<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\DTO\CreateOrderData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCheckoutRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'phone:UA'],
            'city' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:100'],
            'notes' => ['string', 'max:500']
        ];
    }

    public function toDTO(): CreateOrderData
    {
        return CreateOrderData::fromArray($this->validated());
    }
}
