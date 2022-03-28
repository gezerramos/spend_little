<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Level;

class LevelController extends Controller
{

    public function allLevel(Request $request)
    {

        try {
            $levels = Level::all([
                'id', 
                'name'
            ]);
            
            $info = [
                'count' => count($levels),
                'content' => $levels,
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

}
