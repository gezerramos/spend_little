<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post_HamburgerRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hamburger;
use App\Models\Bread;
use App\Models\Meat;
use App\Models\Status_Order;
use App\Models\Optional;
use App\Models\Optionals_Burger;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class AdditionalHamburgerController extends Controller
{
    /**
     * @OA\Post(
     *      path="/hamburger/{hamburger_id}/optionals", 
     *      tags={"/hamburger"},
     *      summary="Hamburger",
     *      description="Rota responsavel recuperar usuario!",
     *      security= {{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         description="Parameter example",
     *         in="path",
     *         name="hamburger_id",
     *         required=true,
     *     ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema( 
     *                 required={"breads_id","meats_id","users_id","status_orders_id"},
     *                 @OA\Property(
     *                     property="optionals",
     *                     type="number"
     *                 ),
     *                 example={
     *                          "optionals":{1, 2,8,9},
     *                          }
     *             )
     *         )
     *     ),
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
    public function AdditionalHamburgerUser(Request $request, $hamburger_id)
    {
        try {
            function error($value)
            {
                throw new \ErrorException($value . ' inválido!');
            }
            is_numeric($hamburger_id) ?: error('hamburger_id');

            $StatusBurger = Hamburger::where('users_id', '=', $request->userID)
                ->where('id', '=', $hamburger_id)->get();


            if (count($StatusBurger) < 1) {
                return response()->json(
                    [
                        "error:" => "true",
                        "message" => "Hamburger inválido!",
                    ],
                    409
                );
            }

            if ($StatusBurger[0]->status_orders_id > 1) {

                $statusBurgerName = Status_Order::find($StatusBurger[0]
                    ->status_orders_id)->name;

                return response()->json(
                    [
                        "error:" => "true",
                        "message" => "Hamburger não pode ser alterado! Status: $statusBurgerName.",
                    ],
                    409
                );
            }

            if ($request->optionals) {
                foreach ($request->optionals as $input => $value) {
                    $OptionalTest = Optional::Optionals_Status($value);

                    if (count($OptionalTest) == 0) {
                        return response()->json([
                            "error:" => "true",
                            "message" => "ID: " . $value . " opcional não existe ou esta desativado!",
                        ], 409);
                    }
                }
            }

            if ($request->optionals) {
                foreach ($request->optionals as $input => $value) {
                    $optionalsburger = new Optionals_Burger;
                    $optionalsburger->optionals_id = $value;
                    $optionalsburger->hamburger_id = $hamburger_id;
                    $optionalsburger->save();
                }
            }

            return response()->json([], 201);
        } catch (\Throwable  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
