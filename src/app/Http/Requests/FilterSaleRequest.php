<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class FilterSaleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'sale_ids' => 'nullable|array|max:5',
            'sale_ids.*' => 'uuid|distinct|exists:sales,id',
            'product_ids' => 'nullable|array|max:5',
            'product_ids.*' => 'uuid|distinct|exists:products,id',
            'final_date' => 'nullable|date|before_or_equal:now|after_or_equal:start_date',
            'start_date' => 'nullable|date|before_or_equal:now|required_if:final_date,not nullable',
            'finalized_date' => 'nullable|date',
            'is_finalized' => 'nullable|boolean',
            'page' => 'nullable|int|min:1',
            'per_page' => 'nullable|int|min:1',
            'order_by' => 'nullable|string|in:asc,desc'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}