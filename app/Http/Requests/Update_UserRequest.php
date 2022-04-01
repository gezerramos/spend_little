<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Update_UserRequest extends FormRequest
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
            'email' => 'min:6|max:80|email:rfc,dns',
            'level_id' => 'min:1 | integer',
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
            'email.max' => 'O e-mail não deve ter mais de 10 caracteres.',
            'email.min' => 'O e-mail deve ter pelo menos 6 caracteres.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'name.max' => 'O name não deve ter mais de 10 caracteres.',
            'name.min' => 'O name deve ter pelo menos 6 caracteres.',
            'name.string' => 'O name deve ser uma string.',
            'level_id.min' => 'O level_id deve conter o no minimo um id válido.',
            'level_id.integer' => 'O level_id deve ser um integer.',
            'status.min' => 'O status deve conter o no minimo um id válido.',
            'status.max' => 'O status não deve ser maior que 1.',
            'status.integer' => 'O status deve ser um integer.',
        ];
    }
}
