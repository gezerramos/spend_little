<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post_UserRequest;
use App\Http\Requests\Patch_UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *      path="/user", 
     *      tags={"/user"},
     *      summary="User",
     *      description="Rota responsavel por listar todos os usuarios!",
     *      security= {{"bearerAuth": {}}},
     *      @OA\Response (
     *          response="200", description="Success"),
     *      @OA\Response (response="201", description="Created"),
     *      @OA\Response (response="401", description="Unauthorized"),
     *      @OA\Response (response="403", description="Forbidden"),
     *      @OA\Response (response="404", description="Not Found"),
     *      @OA\Response (response="500", description="Internal Server Error"),
     * )
     */
    public function allUsers(Request $request)
    {

        try {
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
        } catch (\Throwable  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], $e->status);
        }
    }
    /**
     * @OA\Post(
     *      path="/user", 
     *      tags={"/user"},
     *      summary="user",
     *      description="Rota responsavel por criar usuário!",
     *      security= {{"bearerAuth": {}}},
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
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="level_id",
     *                     type="number"
     *                 ),
     *                 example={"name": "Fulano de Tal",
     *                          "email": "fulano@gmail.com", 
     *                          "password": "123456",
     *                          "level_id": 1}
     *             )
     *         )
     *     ),
     *      @OA\Response (response="200", description="Success"),
     *      @OA\Response (response="201", description="Created"),
     *      @OA\Response (response="401", description="Unauthorized"),
     *      @OA\Response (response="403", description="Forbidden"),
     *      @OA\Response (response="404", description="Not Found"),
     *      @OA\Response (response="500", description="Internal Server Error"),
     * )
     */
    public function createUser(Post_UserRequest $request)
    {
        try {
            $mailTest = User::firstWhere('email', $request['email']);
            if ($mailTest) {
                return response()->json([
                    "error:" => "true",
                    "message" => "Email já existe em nossa base de dados!",
                ], 409);
            }

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->level_id = $request->level_id;
            $user->save();


            return response()->json(
                'Usuário criado com sucesso!',
                200
            );
        } catch (\Throwable  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], $e->status);
        }
    }
    /**
     * @OA\Get(
     *      path="/user/{id}", 
     *      tags={"/user"},
     *      summary="User",
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
     *      @OA\Response (response="500", description="Internal Server Error"),
     * )
     */
    public function getUser($id)
    {
        try {
            $users = User::find($id);
            unset($users->password);

            $info = [
                'content' => $users,
            ];
            return response()->json(
                $info,
                200
            );
        } catch (\Throwable  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], $e->status);
        }
    }
    public function findUserMail($email)
    {
        //$user = User::firstWhere('email', $credenciais['email']);
    }

    /**
     * @OA\Patch(
     *      path="/user/{id}", 
     *      tags={"/user"},
     *      summary="User",
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
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="level_id",
     *                     type="number"
     *                 ),
     *                 example={"name": "Fulano de Tal",
     *                          "email": "fulano@gmail.com", 
     *                          "password": "123456",
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
     *      @OA\Response (response="500", description="Internal Server Error"),
     * )
     */
    public function updateUser(Patch_UserRequest $request, $id)
    {
        try {

            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    "error:" => "true",
                    "message" => "Usuario não encontrado!",
                ], 409);
            }

            $mail = User::User_Email_Equals($id, $request['email'],);
            if (count($mail) > 0) {
                return response()->json([
                    "error:" => "true",
                    "message" => "Email já existe em nossa base de dados!",
                ], 409);
            }

            $user->update($request->all());

            return response()->json(
                [],
                200
            );
        } catch (\Throwable  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], $e->status);
        }
    }

    public function deleteUser($id)
    {
        // logic to delete a User record goes here
    }
}
