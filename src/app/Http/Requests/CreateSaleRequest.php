<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class CreateSaleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'product_ids' => 'required|array',
            'product_ids.*' => 'integer|distinct|exists:products,id'
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