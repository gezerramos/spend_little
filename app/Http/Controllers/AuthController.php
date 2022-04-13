<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/authentication", 
     *      tags={"/authentication"},
     *      summary="authentication",
     *      description="Rota responsavel por se autenticar!",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  required={"email","password"},
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "fulano@gmail.com", "password": "123456"}
     *             )
     *         )
     *     ),
     *      @OA\Response (response="200", description="Success"),
     *      @OA\Response (response="201", description="Created"),
     *      @OA\Response (response="401", description="Unauthorized"),
     *      @OA\Response (response="403", description="Forbidden"),
     *      @OA\Response (response="404", description="Not Found"),
     *      @OA\Response (response="409", description="Conflict"),
     *      @OA\Response (response="500", description="Internal Server Error"),
     * )
     */
    public function post_Auth(Request $request)
    {


        $this->validate($request, array(
            'email' => 'required|min:6|max:80|email:rfc,dns',
            'password' => 'required|min:4|max:80',
        ));

        $credenciais = $request->only(['email', 'password']);
        //config()->set('jwt.ttl', 60*60*7); //time limit exp

        $token = auth('api')->attempt($credenciais);

        if (!$token) {
            //throw ValidationException::withMessages(['field_name' => 'forbidden!']);
            return response()->json([
                "errors:" => [
                "message" => "Usuário ou senha inválido!"],
            ], 403);
        };

        $user = User::innerjoinUserLevel($credenciais['email']);
        $user->token = $token;

        return response()->json([
            "error:" => "false",
            "user" => $user,
        ], 201);
    }
    /**
     * @OA\Get(
     *      path="/authentication/token", 
     *      tags={"/authentication"},
     *      summary="Authentication",
     *      description="Responsible route verify token!",
     *      security= {{"bearerAuth": {}}},
     *      @OA\Response (
     *          response="200", description="Success"),
     *      @OA\Response (response="201", description="Created"),
     *      @OA\Response (response="202", description="Accepted"),
     *      @OA\Response (response="401", description="Unauthorized"),
     *      @OA\Response (response="403", description="Forbidden"),
     *      @OA\Response (response="404", description="Not Found"),
     *      @OA\Response (response="409", description="Conflict"),
     *      @OA\Response (response="500", description="Internal Server Error"),
     * )
     */

    public function Token_Verify(Request $request)
    {
        try {

            return response()->json([
                "error:" => "true",
                "message" => "Token valído!",
            ], 202);
        } catch (\Exception  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
