<?php

namespace App\Http\Requests;

use App\Traits\IsApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    use IsApiRequest;

    /** Determine if the user is authorized to make this request. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'seller_id' => ['required', 'integer', 'exists:sellers,id'],
            'amount'    => ['required', 'numeric', 'min:0'],
            'sale_date' => ['required', 'date'],
        ];
    }

    /**
     * Get the custom error messages for the validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'seller_id.required' => 'The seller_id field is required.',
            'seller_id.integer'  => 'The seller_id must be an integer.',
            'seller_id.exists'   => 'The selected seller_id is invalid.',
            'amount.required'    => 'The amount field is required.',
            'amount.numeric'     => 'The amount must be a number.',
            'amount.min'         => 'The amount must be at least 0.',
            'sale_date.required' => 'The sale_date field is required.',
            'sale_date.date'     => 'The sale_date must be a valid date.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $data = [
            'seller_id' => isset($this->seller_id) ? (int) $this->seller_id : null, // @phpstan-ignore-line
            'amount'    => isset($this->amount) ? (float) $this->amount : null, // @phpstan-ignore-line
            'sale_date' => (isset($this->sale_date) && is_string($this->sale_date)) ? (string) trim(strip_tags($this->sale_date)) : null,
        ];

        $this->removeNullFields($data);
        $this->merge($data);
    }
}
