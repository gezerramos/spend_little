<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/admin/user", 
     *      tags={"/admin/user"},
     *      summary="User : admin",
     *      description="Rota responsavel por listar todos os usuarios!",
     *      security= {{"bearerAuth": {}}},
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
    public function allUsers(Request $request)
    {

        $users = User::all([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
            'level_id'
        ]);

        $info = [
            'count' => count($users),
            'content' => $users,
        ];
        return response()->json(
            $info,
            200
        );
    }

    /**
     * @OA\Get(
     *      path="/admin/user/{id}", 
     *      tags={"/admin/user"},
     *      summary="User : admin",
     *      description="Rota responsavel recuperar usuario!",
     *      security= {{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         description="Parameter example",
     *         in="path",
     *         name="id",
     *         required=true,
     *     ),
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
    public function getUser($id)
    {

        $users = User::find($id);
        unset($users->password);

        $info = [
            'content' => $users,
        ];
        return response()->json(
            $info,
            200
        );
    }
    public function findUserMail($email)
    {
        //$user = User::firstWhere('email', $credenciais['email']);
    }

    /**
     * @OA\Patch(
     *      path="/admin/user/{id}", 
     *      tags={"/admin/user"},
     *      summary="User : admin",
     *      description="Rota responsavel por editar usuario!",
     *      security= {{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         description="Parameter example",
     *         in="path",
     *         name="id",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
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
     *                     property="level_id",
     *                     type="number"
     *                 ),
     *                 example={"name": "Fulano de Tal",
     *                          "email": "fulano@gmail.com", 
     *                          "level_id": 1}
     *             )
     *         )
     *     ),
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
    public function updateUser(Request $request, $id)
    {

        $this->validate($request, array(
            'name' => 'required|min:6|max:100 | string',
            'email' => 'required | string |min:6|max:80|email:rfc,dns| unique:users',
            'level_id' => 'min:1 | integer',
            'status' => 'min:0 | max:1 | integer',
        ));

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                "error:" => "true",
                "message" => "Usuario n??o encontrado!",
            ], 409);
        }

        $mail = User::User_Email_Equals($id, $request['email'],);
        if (count($mail) > 0) {
            return response()->json([
                "error:" => "true",
                "message" => "Email j?? existe em nossa base de dados!",
            ], 409);
        }
        //validando apenas o que esta na regra
        $requestEquals = array();
        foreach ($request->all() as $input => $value) {
            if (array_key_exists($input, $request->rules())) {
                $requestEquals[$input] = $value;
            }
        }
        $user->update($requestEquals);

        return response()->json(
            [],
            200
        );
    }

    public function deleteUser($id)
    {
        // logic to delete a User record goes here
    }
}
