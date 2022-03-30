<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post_UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Patch_AccountRequest;


class AccountController extends Controller
{

    /**
     * @OA\Get(
     *      path="/account/me", 
     *      tags={"/account"},
     *      summary="Account",
     *      description="Responsible route recover account data!!",
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
    public function getInfoAccount(Request $request)
    {
        try {
            $account = User::innerjoinAccountInfo($request->userID);
            unset($account->password);

            $info = [
                'content' => $account,
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
     * @OA\Get(
     *      path="/account/refresh", 
     *      tags={"/account"},
     *      summary="Account",
     *      description="Responsible route refresh token!",
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

    public function refreshToken()
    {
        $token = JWTAuth::parseToken()->refresh();
        return response()->json(
            ['token' => $token],
            201
        );
    }
    public function findUserMail($email)
    {
        //$user = User::firstWhere('email', $credenciais['email']);
    }
    /**
     * @OA\Patch(
     *      path="/account/me", 
     *      tags={"/account"},
     *      summary="Account",
     *      description="Rota responsavel por editar conta do usuario logado!",
     *      security= {{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               type="object", 
     *               @OA\Property(
     *                  property="image",
     *                  type="array",
     *                  @OA\Items(
     *                       type="string",
     *                       format="binary",
     *                  ),
     *               ),
     *           ),
     *       ),
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
     *                 example={"name": "Fulano de Tal",
     *                          "email": "fulano@gmail.com",
     *                          "password": "123456"
     *                          }
     *             )
     *         )
     *   ),
     *      @OA\Response (
     *          response="200", description="Success"),
     *      @OA\Response (response="201", description="Created"),
     *      @OA\Response (response="401", description="Unauthorized"),
     *      @OA\Response (response="403", description="Forbidden"),
     *      @OA\Response (response="404", description="Not Found"),
     *      @OA\Response (response="500", description="Internal Server Error"),
     * )
     */
    public function updateAccount(Patch_AccountRequest $request)
    {
        try {

            $user = User::find($request->userID);
            if (!$user) {
                return response()->json([
                    "error:" => "true",
                    "message" => "Usuario não encontrado!",
                ], 409);
            }

            $mail = User::User_Email_Equals($request->userID, $request['email'],);
            if (count($mail) > 0) {
                return response()->json([
                    "error:" => "true",
                    "message" => "Email já existe em nossa base de dados!",
                ], 409);
            }
            //validando apenas o que esta na regra
            $requestEquals = array();
            foreach ($request->all() as $input => $value) {
                if (array_key_exists($input, $request->rules())) {
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