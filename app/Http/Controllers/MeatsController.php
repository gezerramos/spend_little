<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Meat;

class MeatsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/meats", 
     *      tags={"/meats"},
     *      summary="Meat",
     *      description="Rota responsavel por listar todas carnes!",
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
    public function allMeats(Request $request)
    {

        $levels = Meat::all([
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
