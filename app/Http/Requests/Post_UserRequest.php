<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => 'required|min:6|max:80|email:rfc,dns',
            'password' => 'required|min:4|max:40 | string',
            'level_id' => 'required|min:1 | integer',
        ];
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
            'name.required' => 'O name é obrigatório!',
            'name.max' => 'O name não deve ter mais de 10 caracteres.',
            'name.min' => 'O name deve ter pelo menos 6 caracteres.',
            'name.string' => 'O name deve ser uma string.',
            'level_id.required' => 'O level_id é obrigatório!',
            'level_id.min' => 'O level_id deve conter o no minimo um id válido.',
            'level_id.integer' => 'O level_id deve ser um integer.',

        ];
    }
}
