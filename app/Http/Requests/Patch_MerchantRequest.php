<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Patch_MerchantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'min:6|max:100 | string',
            'corporate_name' => 'min:6|max:100 | string',
            'description' => 'min:6|max:100 | string',
            'status' => 'min:0 | max:1 | integer',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                "error:" => "true",
                "message" => $validator->errors(),
            ], 409)
        );
    }
    public function messages()
    {
        return [
            'name.max' => 'O name não deve ter mais de 100 caracteres.',
            'name.min' => 'O name deve ter pelo menos 4 caracteres.',
            'name.string' => 'O name deve ser uma string.',

            'corporate_name.max' => 'O corporate_name não deve ter mais de 100 caracteres.',
            'corporate_name.min' => 'O corporate_name deve ter pelo menos 6 caracteres.',
            'corporate_name.string' => 'O corporate_name deve ser uma string.',

            'description.max' => 'O description não deve ter mais de 200 caracteres.',
            'description.min' => 'O description deve ter pelo menos 4 caracteres.',
            'description.string' => 'O description deve ser uma string.',

            'status.min' => 'O status deve conter o no minimo 0 válido.',
            'status.max' => 'O status não deve ter mais de 1 caracteres.',
            'status.integer' => 'O status deve ser um integer.',
        ];
    }
}
