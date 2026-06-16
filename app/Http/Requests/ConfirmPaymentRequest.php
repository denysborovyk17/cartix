<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\Data\ConfirmPaymentData;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmPaymentRequest extends FormRequest
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
            'card_last4' => ['required', 'string', 'size:16']
        ];
    }

    public function getData(): ConfirmPaymentData
    {
        return ConfirmPaymentData::fromArray($this->validated());
    }
}
