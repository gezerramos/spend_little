<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;


class UpdateAccountController extends Controller
{

    /**
     * @OA\Patch(
     *      path="/account/me", 
     *      tags={"/account"},
     *      summary="Account",
     *      description="Rota responsavel por editar conta do usuario logado!",
     *      security= {{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema( 
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="number",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="complement",
     *                     type="string"
     *                 ),
     *                 example={"name": "Fulano de Tal",
     *                          "email": "fulano@gmail.com", 
     *                          "password": "123456",
     *                          "address": "Rua teste ",
     *                          "phone": "(73) 988203656",
     *                          "number": "18",
     *                          "complement":"bloco10ap23"}
     *             )
     *         )
     *   ),
     *      @OA\Response (
     *          response="200", description="Success"),
     *      @OA\Response (response="201", description="Created"),
     *      @OA\Response (response="401", description="Unauthorized"),
     *      @OA\Response (response="403", description="Forbidden"),
     *      @OA\Response (response="404", description="Not Found"),
     *      @OA\Response (response="409", description="Conflict"),
     *      @OA\Response (response="500", description="Internal Server Error"),
     * )
     */
    public function updateAccount(Request $request)
    {

        $arrValidate = array(
            'name' => 'min:6|max:100 | string',
            'email' => 'min:6|max:80|email:rfc,dns',
            'level_id' => 'min:1 | integer',
            'status' => 'min:0 | max:1 | integer',
            'password' => 'min:4|max:40 | string',
            'address' => 'min:4|max:80 | string',
            'number' => 'min:4|max:40 | integer',
            'phone' => 'min:4|max:20 | string',
            'complement' => 'min:4|max:30 | string',
            'imagem' => 'file|mimes:jpeg,jpg,png|max:10000', // max 10000kb
        );
        $this->validate($request, $arrValidate);

        $user = User::find($request->userID);
        if (!$user) {
            return response()->json([
                "error:" => "true",
                "message" => "Usuario n??o encontrado!",
            ], 409);
        }

        $mail = User::User_Email_Equals($request->userID, $request['email'],);
        if (count($mail) > 0) {
            return response()->json([
                "error:" => "true",
                "message" => "Email j?? existe em nossa base de dados!",
            ], 409);
        }

        //validando apenas o que esta na regra
        $requestEquals = array();
        foreach ($request->all() as $input => $value) {
            if (array_key_exists($input, $arrValidate)) {
                $requestEquals[$input] = $value;
            }
        }

        if ($request['password']) {
            $requestEquals['password'] = bcrypt($request->password);
        }

        $user->update($requestEquals);

        return response()->json(
            [],
            200
        );
    }
}
