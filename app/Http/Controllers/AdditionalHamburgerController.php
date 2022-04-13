<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hamburger;
use App\Models\Status_Order;
use App\Models\Optional;
use App\Models\Optionals_Burger;

class AdditionalHamburgerController extends Controller
{
    /**
     * @OA\Post(
     *      path="/hamburger/{hamburger_id}/optionals", 
     *      tags={"/hamburger"},
     *      summary="Hamburger",
     *      description="Rota responsavel adicionar novos adicionais ao hamburger!",
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
    public function AdditionalHamburgerUser(Request $request, $hamburgerid)
    {


        $request["hamburgerid"] = $hamburgerid;
        $arrValidate = array(
            "optionals"    => "array|min:1 ",
            "hamburgerid" => 'required | min:1 | integer',
        );
        $this->validate($request, $arrValidate);

        $StatusBurger = Hamburger::where('users_id', '=', $request->userID)
            ->where('id', '=', $hamburgerid)->get();


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
                $optionalsburger->hamburgerid = $hamburgerid;
                $optionalsburger->save();
            }
        }

        return response()->json([], 201);
    }
}
