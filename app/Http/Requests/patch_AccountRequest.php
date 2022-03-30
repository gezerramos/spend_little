<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            
        ];
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
            'password_last.required' => 'O password_last é obrigatório!',
            'password_last.max' => 'O password_last não deve ter mais de 10 caracteres.',
            'password_last.min' => 'O password_last deve ter pelo menos 6 caracteres.',
            'password_new.required' => 'O password_new é obrigatório!',
            'password_new.max' => 'O password_new não deve ter mais de 10 caracteres.',
            'password_new.min' => 'O password_new deve ter pelo menos 6 caracteres.',
        ];
    }
}
