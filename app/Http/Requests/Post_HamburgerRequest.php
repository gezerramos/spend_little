<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Post_HamburgerRequest extends FormRequest
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
            'breads_id' => 'required | min:1 | integer',
            'meats_id' => 'required | min:1 | integer',
            "optionals"    => "array|min:1",
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

            'users_id.required' => 'O users_id é obrigatório!',
            'users_id.min' => 'O users_id deve conter o no minimo 1 válido.',
            'users_id.integer' => 'O users_id deve ser um integer.',

            'breads_id.required' => 'O breads_id é obrigatório!',
            'breads_id.min' => 'O breads_id deve conter o no minimo 1 válido.',
            'breads_id.integer' => 'O breads_id deve ser um integer.',

            'meats_id.required' => 'O meats_id é obrigatório!',
            'meats_id.min' => 'O meats_id deve conter o no minimo 1 válido.',
            'meats_id.integer' => 'O meats_id deve ser um integer.',

            'status_orders_id.required' => 'O status_orders_id é obrigatório!',
            'status_orders_id.min' => 'O status_orders_id deve conter o no minimo 1 válido.',
            'status_orders_id.integer' => 'O status_orders_id deve ser um integer.',

            'optionals.required' => 'O optionals é obrigatório!',
            'optionals.min' => 'O optionals deve conter o no minimo 1 válido.',
            'optionals.array' => 'O optionals deve ser um array.',
        ];
    }
}
