<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Patch_AccountRequest extends FormRequest
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
            'password' => 'min:4|max:40 | string',
            'address' => 'min:4|max:80 | string',
            'number' => 'min:4|max:40 | integer',
            'phone' => 'min:4|max:20 | string',
            'complement' => 'min:4|max:30 | string',
            'imagem' => 'file|mimes:jpeg,jpg,png|max:10000' // max 10000kb
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
            'password.max' => 'O password não deve ter mais de 10 caracteres.',
            'password.min' => 'O password deve ter pelo menos 6 caracteres.',
            'imagem.max' => 'A imagem não deve ter mais de 10000kb.',
            'imagem.mimes' => 'A imagem é obrigatória.',
            'number.min' => 'O number deve conter o no minimo um id válido.',
            'number.integer' => 'O number deve ser um integer.',
            'address.max' => 'O address não deve ter mais de 80 caracteres.',
            'address.min' => 'O address deve ter pelo menos 4 caracteres.',
            'address.string' => 'O address deve ser uma string.',
            'phone.max' => 'O phone não deve ter mais de 20 caracteres.',
            'phone.min' => 'O phone deve ter pelo menos 4 caracteres.',
            'phone.string' => 'O phone deve ser uma string.',
            'complement.max' => 'O complement não deve ter mais de 30 caracteres.',
            'complement.min' => 'O complement deve ter pelo menos 4 caracteres.',
            'complement.string' => 'O complement deve ser uma string.',

        ];
    }
}
