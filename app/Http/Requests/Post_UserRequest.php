<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Post_UserRequest extends FormRequest
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
            'name' => 'required|min:6|max:100 | string',
            'email' => 'required | string |min:6|max:80|email:rfc,dns| unique:users',
            'password' => 'required|min:4|max:40 | string',
            'address' => 'required|min:4|max:80 | string',
            'number' => 'required|min:4|max:40 | integer',
            'phone' => 'required|min:4|max:20 | string |celular_com_codigo',
            'complement' => 'min:4|max:30 | string',
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
            'password.required' => 'O password é obrigatório!',
            'password.max' => 'O password não deve ter mais de 10 caracteres.',
            'password.min' => 'O password deve ter pelo menos 6 caracteres.',
            'email.required' => 'O email é obrigatório!',
            'email.max' => 'O e-mail não deve ter mais de 10 caracteres.',
            'email.min' => 'O e-mail deve ter pelo menos 6 caracteres.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'O e-mail deve ser unico.',
            'name.required' => 'O name é obrigatório!',
            'name.max' => 'O name não deve ter mais de 10 caracteres.',
            'name.min' => 'O name deve ter pelo menos 6 caracteres.',
            'name.string' => 'O name deve ser uma string.',
            'number.required' => 'O number é obrigatório!',
            'number.min' => 'O number deve conter o no minimo um id válido.',
            'number.integer' => 'O number deve ser um integer.',
            'address.max' => 'O address não deve ter mais de 80 caracteres.',
            'address.min' => 'O address deve ter pelo menos 4 caracteres.',
            'address.string' => 'O address deve ser uma string.',
            'address.required' => 'O address é obrigatório!',
            'phone.max' => 'O phone não deve ter mais de 20 caracteres.',
            'phone.min' => 'O phone deve ter pelo menos 4 caracteres.',
            'phone.string' => 'O phone deve ser uma string.',
            'phone.required' => 'O phone é obrigatório!',
            'complement.max' => 'O complement não deve ter mais de 30 caracteres.',
            'complement.min' => 'O complement deve ter pelo menos 4 caracteres.',
            'complement.string' => 'O complement deve ser uma string.',
        ];
    }
}
