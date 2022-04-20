<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Optional;

class OptionalController extends Controller
{
    /**
     * @OA\Get(
     *      path="/optionals", 
     *      tags={"/optionals"},
     *      summary="Optional",
     *      description="Rota responsavel por listar todas opcionais!",
     *      security= {{"bearerAuth": {}}},
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
    public function allOptionals(Request $request)
    {

        $levels = Optional::all([
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
    }
}
