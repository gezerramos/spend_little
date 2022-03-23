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

            $user = User::firstWhere('email', $request->get('email'));
            if (!isset($user->email)) {
                throw ValidationException::withMessages(['field_name' => 'Unauthorized']);
            }

            if ($user->password != $request->password) {
                throw ValidationException::withMessages(['field_name' => 'Unauthorized']);
            }

            $teste = [
                'email' => $user->email,
                'password' => $user->password,
            ];

            return response()->json($teste, 200);
        } catch (\Throwable  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], 401);
        }
    }
}
