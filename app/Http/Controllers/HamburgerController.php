<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post_HamburgerRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hamburger;
use Illuminate\Validation\ValidationException;

class HamburgerController extends Controller
{
    /**
     * @OA\Post(
     *      path="/hamburger", 
     *      tags={"/hamburger"},
     *      summary="Hamburger",
     *      security= {{"bearerAuth": {}}},
     *      description="Rota responsavel por criar hamburger!",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema( 
     *                 required={"breads_id","meats_id","users_id","status_orders_id"},
     *                 @OA\Property(
     *                     property="breads_id",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="meats_id",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="users_id",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="status_orders_id",
     *                     type="number"
     *                 ),
     * 
     *                 example={"breads_id": 1,
     *                          "meats_id": 1,
     *                          "users_id": 1,
     *                          "status_orders_id": 1,
     *                          "optionals":{1, 2,8,9},
     *                          }
     *             )
     *         )
     *     ),
     *      @OA\Response (response="200", description="Success"),
     *      @OA\Response (response="201", description="Created"),
     *      @OA\Response (response="401", description="Unauthorized"),
     *      @OA\Response (response="403", description="Forbidden"),
     *      @OA\Response (response="404", description="Not Found"),
     *      @OA\Response (response="409", description="Conflict"),
     *      @OA\Response (response="500", description="Internal Server Error"),
     * )
     */
    public function createHamburger(Post_HamburgerRequest $request)
    {
        try {

            $mailTest = Hamburger::firstWhere('name', $request['name']);
            if ($mailTest) {
                return response()->json([
                    "error:" => "true",
                    "message" => "o Nome já existe em nossa base de dados!",
                ], 409);
            }

            // $merchant = new Hamburger;
            // $merchant->name = $request->name;
            // $merchant->corporate_name = $request->corporate_name;

            // $merchant->save();


            return response()->json(
                'Dados salvos com sucesso!',
                201
            );
        } catch (\Throwable  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], $e->status);
        }
    }
}
