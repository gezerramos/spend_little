<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post_AuthRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AuthController extends Controller
{
    public function post_Auth(Post_AuthRequest $request)
    {
        try {

            $credenciais = $request->only(['email', 'password']);
            //config()->set('jwt.ttl', 60*60*7); //time limit exp

            $token = auth('api')->attempt($credenciais);

            if (!$token) {
                //throw ValidationException::withMessages(['field_name' => 'forbidden!']);
                return response()->json([
                    "error:" => "true",
                    "message" => "Usuário ou senha inválido!",
                ], 403);
            };

            $user = User::innerjoinUserLevel($credenciais['email']);
            $user->token = $token;

            return response()->json([
                "error:" => "false",
                "user" => $user,
            ], 201);
        } catch (\Exception  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
