<?php

namespace App\Http\Requests;

use App\Traits\IsApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SellerRequest extends FormRequest
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
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('sellers', 'email')->ignore($this->id)],
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
            'name.required'  => 'The name field is required.',
            'name.max'       => 'The name must not exceed 100 characters.',
            'email.required' => 'The email field is required.',
            'email.email'    => 'The email must be a valid email address.',
            'email.unique'   => 'The email has already been taken.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $data = [
            'name'  => (isset($this->name) && is_string($this->name)) ? (string) trim(strip_tags($this->name)) : null,
            'email' => (isset($this->email) && is_string($this->email)) ? (string) trim(strip_tags($this->email)) : null,
        ];

        $this->removeNullFields($data);
        $this->merge($data);
    }
}
