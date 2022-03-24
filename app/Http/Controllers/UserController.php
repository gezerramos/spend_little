<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{

    public function allUsers(Request $request)
    {

        try {
            $users = User::all();
            $info = [
                'count'=> count($users),
                'content'=>$users,
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

    public function createStudent(Request $request)
    {
        // logic to create a student record goes here
    }

    public function getStudent($id)
    {
        // logic to get a student record goes here
    }

    public function updateStudent(Request $request, $id)
    {
        // logic to update a student record goes here
    }

    public function deleteStudent($id)
    {
        // logic to delete a student record goes here
    }
}
