<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post_UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;


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
