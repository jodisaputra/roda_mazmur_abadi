<?php

namespace App\Http\Requests\FRONTEND;

use Illuminate\Foundation\Http\FormRequest;

class CategoryShowRequest extends FormRequest
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
            'sort' => 'nullable|string|in:name_asc,name_desc,latest,price_low,price_high',
            'page' => 'nullable|integer|min:1'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'sort.in' => 'Invalid sort option selected.',
            'page.integer' => 'Page must be a valid number.',
            'page.min' => 'Page must be at least 1.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'sort' => 'sort option',
            'page' => 'page number'
        ];
    }
}
