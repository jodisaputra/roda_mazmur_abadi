<?php

namespace App\Http\Requests\BACKEND;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShelfProductsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'products' => 'array',
            'products.*' => 'exists:products,id',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'products.array' => 'The products must be an array.',
            'products.*.exists' => 'The selected product does not exist.',
        ];
    }
}
