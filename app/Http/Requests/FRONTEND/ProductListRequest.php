<?php

namespace App\Http\Requests\FRONTEND;

use Illuminate\Foundation\Http\FormRequest;

class ProductListRequest extends FormRequest
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
            'sort' => 'nullable|string|in:latest,oldest,name_asc,name_desc,price_low,price_high',
            'category' => 'nullable|string|exists:categories,slug',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0|gte:price_min',
            'in_stock' => 'nullable|boolean',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'sort.in' => 'Invalid sort option selected.',
            'category.exists' => 'The selected category does not exist.',
            'price_min.numeric' => 'Minimum price must be a valid number.',
            'price_max.numeric' => 'Maximum price must be a valid number.',
            'price_max.gte' => 'Maximum price must be greater than or equal to minimum price.',
            'page.integer' => 'Page must be a valid number.',
            'page.min' => 'Page must be at least 1.',
            'per_page.max' => 'Results per page cannot exceed 100.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'sort' => 'sort option',
            'category' => 'category',
            'price_min' => 'minimum price',
            'price_max' => 'maximum price',
            'in_stock' => 'stock filter',
            'page' => 'page number',
            'per_page' => 'results per page'
        ];
    }
}
