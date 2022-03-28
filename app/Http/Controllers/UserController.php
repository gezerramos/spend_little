<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post_UserRequest;
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

    public function createUser(Post_UserRequest $request)
    {
        try {

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
    public function updateUser(Request $request, $id)
    {
        // logic to update a User record goes here
    }

    public function deleteUser($id)
    {
        // logic to delete a User record goes here
    }
}
