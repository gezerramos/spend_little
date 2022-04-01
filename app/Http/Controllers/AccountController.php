<?php

namespace App\Http\Controllers;

//use App\Http\Requests\Post_UserRequest;
//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
//use \Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Update_AccountRequest;
//use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    // /**
    //  * @OA\Post(
    //  *      path="/account", 
    //  *      tags={"/account"},
    //  *      summary="Account",
    //  *      description="Rota responsavel por criar account!",
    //  *     @OA\RequestBody(
    //  *         @OA\MediaType(
    //  *             mediaType="application/json",
    //  *             @OA\Schema( 
    //  *                 required={"name","email","password","level_id"},
    //  *                 @OA\Property(
    //  *                     property="name",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="email",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="password",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="address",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="number",
    //  *                     type="number"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="phone",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="complement",
    //  *                     type="string"
    //  *                 ),
    //  *                 example={"name": "Fulano de Tal",
    //  *                          "email": "fulano@gmail.com", 
    //  *                          "password": "123456",
    //  *                          "address": "Rua teste ",
    //  *                          "phone": "(73) 988203656",
    //  *                          "number": "18",
    //  *                          "complement":"bloco10ap23"}
    //  *             )
    //  *         )
    //  *     ),
    //  *      @OA\Response (response="200", description="Success"),
    //  *      @OA\Response (response="201", description="Created"),
    //  *      @OA\Response (response="401", description="Unauthorized"),
    //  *      @OA\Response (response="403", description="Forbidden"),
    //  *      @OA\Response (response="404", description="Not Found"),
    //  *      @OA\Response (response="409", description="Conflict"),
    //  *      @OA\Response (response="500", description="Internal Server Error"),
    //  * )
    //  */
    // public function createUser(Post_UserRequest $request)
    // {
    //     try {
    //         $mailTest = User::firstWhere('email', $request['email']);
    //         if ($mailTest) {
    //             return response()->json([
    //                 "error:" => "true",
    //                 "message" => "Email já existe em nossa base de dados!",
    //             ], 409);
    //         }

    //         $user = new User;
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->password = bcrypt($request->password);
    //         $user->level_id = 1;
    //         $user->address =$request->address;
    //         $user->phone =$request->phone;
    //         $user->number =$request->number;
    //         $user->complement =$request->complement;
    //         $user->save();


    //         return response()->json(
    //             'Usuário criado com sucesso!',
    //             201
    //         );
    //     } catch (\Throwable  $e) {

    //         return response()->json([
    //             "error:" => "true",
    //             "message" => $e->getMessage(),
    //         ], $e->status);
    //     }
    // }
    // /**
    //  * @OA\Get(
    //  *      path="/account/me", 
    //  *      tags={"/account"},
    //  *      summary="Account",
    //  *      description="Responsible route recover account data!!",
    //  *      security= {{"bearerAuth": {}}},
    //  *      @OA\Response (
    //  *          response="200", description="Success"),
    //  *      @OA\Response (response="201", description="Created"),
    //  *      @OA\Response (response="401", description="Unauthorized"),
    //  *      @OA\Response (response="403", description="Forbidden"),
    //  *      @OA\Response (response="404", description="Not Found"),
    //  *      @OA\Response (response="409", description="Conflict"),
    //  *      @OA\Response (response="500", description="Internal Server Error"),
    //  * )
    //  */
    // public function getInfoAccount(Request $request)
    // {
    //     try {
    //         $account = User::innerjoinAccountInfo($request->userID);
    //         unset($account->password);

    //         $info = [
    //             'content' => $account,
    //         ];
    //         return response()->json(
    //             $info,
    //             200
    //         );
    //     } catch (\Throwable  $e) {

    //         return response()->json([
    //             "error:" => "true",
    //             "message" => $e->getMessage(),
    //         ], $e->status);
    //     }
    // }

    // /**
    //  * @OA\Get(
    //  *      path="/account/refresh", 
    //  *      tags={"/account"},
    //  *      summary="Account",
    //  *      description="Responsible route refresh token!",
    //  *      security= {{"bearerAuth": {}}},
    //  *      @OA\Response (
    //  *          response="200", description="Success"),
    //  *      @OA\Response (response="201", description="Created"),
    //  *      @OA\Response (response="401", description="Unauthorized"),
    //  *      @OA\Response (response="403", description="Forbidden"),
    //  *      @OA\Response (response="404", description="Not Found"),
    //  *      @OA\Response (response="409", description="Conflict"),
    //  *      @OA\Response (response="500", description="Internal Server Error"),
    //  * )
    //  */

    // public function refreshToken()
    // {
    //     $token = JWTAuth::parseToken()->refresh();
    //     return response()->json(
    //         ['token' => $token],
    //         201
    //     );
    // }
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
    public function updateAccount(Update_AccountRequest $request)
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
     /*        if ($request['password']) {
                $requestEquals['password'] = bcrypt($request->password);
            } 

            $user->update($request); */

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

    // /**
    //  * @OA\Post(
    //  *      path="/account/me/image", 
    //  *      tags={"/account"},
    //  *      summary="Account",
    //  *      description="Rota responsavel por editar conta do usuario logado!",
    //  *      security= {{"bearerAuth": {}}},
    //  *   @OA\RequestBody(
    //  *       @OA\MediaType(
    //  *           mediaType="multipart/form-data",
    //  *           @OA\Schema(
    //  *               type="object", 
    //  *               @OA\Property(
    //  *                  property="imagem",
    //  *                  type="array",
    //  *                  @OA\Items(
    //  *                       type="string",
    //  *                       format="binary",
    //  *                  ),
    //  *               ),
    //  *           ),
    //  *       ),
    //  *   ),
    //  *      @OA\Response (
    //  *          response="200", description="Success"),
    //  *      @OA\Response (response="201", description="Created"),
    //  *      @OA\Response (response="401", description="Unauthorized"),
    //  *      @OA\Response (response="403", description="Forbidden"),
    //  *      @OA\Response (response="404", description="Not Found"),
    //  *      @OA\Response (response="409", description="Conflict"),
    //  *      @OA\Response (response="500", description="Internal Server Error"),
    //  * )
    //  */
    // public function updateAccountImage(Patch_AccountRequest $request)
    // {
    //     try {

    //         if (!$request->file('imagem')) {
    //             return response()->json([
    //                 "error:" => "true",
    //                 "message" => "Imagem não foi enviada!",
    //             ], 409);
    //         }
    //         $user = User::find($request->userID);

    //         Storage::disk('public')->delete($user->image);//delete imagem antiga
            
    //         $image = $request->file('imagem');

    //         $image_urn = $image->store('imagens', 'public');

    //         $user->image = $image_urn;
    //         $user->update();

    //         return response()->json(
    //             [],
    //             200
    //         );
    //     } catch (\Throwable  $e) {

    //         return response()->json([
    //             "error:" => "true",
    //             "message" => $e->getMessage(),
    //         ], $e->status);
    //     }
    // }

    // public function deleteUser($id)
    // {
    //     // logic to delete a User record goes here
    // }
}
