<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post_UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{

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

    public function getUser($id)
    {
        // logic to get a User record goes here
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
