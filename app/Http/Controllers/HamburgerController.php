<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hamburger;
use App\Models\Bread;
use App\Models\Meat;
use App\Models\Optional;
use App\Models\Optionals_Burger;

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
     *                 example={"breads_id": 1,
     *                          "meats_id": 1,
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
    public function createHamburger(Request $request)
    {
        $arrValidate = array(
            'breads_id' => 'required | min:1 | integer',
            'meats_id' => 'required | min:1 | integer',
            "optionals"    => "array|min:1",
        );
        $this->validate($request, $arrValidate);

        $BreadTest = Bread::Bread_Status($request['breads_id']);
        if (count($BreadTest) == 0) {
            return response()->json([
                "error:" => "true",
                "message" => "ID: " . $request['breads_id'] . " do p??o n??o existe!",
            ], 409);
        }
        $MeatTest = Meat::Meat_Status($request['meats_id']);
        if (count($MeatTest) == 0) {
            return response()->json([
                "error:" => "true",
                "message" => "ID: " . $request['meats_id'] . " da carne n??o existe!",
            ], 409);
        }

        if ($request->optionals) {
            foreach ($request->optionals as $input => $value) {
                $OptionalTest = Optional::Optionals_Status($value);

                if (count($OptionalTest) == 0) {
                    return response()->json([
                        "error:" => "true",
                        "message" => "ID: " . $value . " opcional n??o existe ou esta desativado!",
                    ], 409);
                }
            }
        }

        $hamburger = new Hamburger;
        $hamburger->breads_id = $request['breads_id'];
        $hamburger->meats_id = $request['meats_id'];
        $hamburger->users_id = $request->userID;
        $hamburger->status_orders_id = 1;
        $hamburger->save();

        $id_burger = $hamburger->id;

        if ($request->optionals) {
            foreach ($request->optionals as $input => $value) {
                $optionalsburger = new Optionals_Burger;
                $optionalsburger->optionals_id = $value;
                $optionalsburger->hamburger_id = $id_burger;
                $optionalsburger->save();
            }
        }

        return response()->json(
            $hamburger->id,
            201
        );
    }

    /**
     * @OA\Get(
     *      path="/hamburger", 
     *      tags={"/hamburger"},
     *      summary="Hamburger",
     *      description="Rota responsavel por listar todas hamburgers!",
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
    public function allHamburgerUser(Request $request)
    {

            $amburgers = Hamburger::innerjoinHamburgerMeInfo($request->userID);
            //optionals_id,hamburger_id 

            for ($i = 0; $i <= count($amburgers) - 1; $i++) {

                $optionals_items = Optionals_Burger::innerjoinHamburgerOpMeInfo($amburgers[$i]->id);
                $optionals_price = 0;
                if (count($optionals_items) > 0) {

                    for ($o = 0; $o <= count($optionals_items) - 1; $o++) {
                        $optionals_price =   $optionals_price + $optionals_items[$o]->price;
                    }
                }
                $total_price = $amburgers[$i]->breads_price + $amburgers[$i]->meats_price + $optionals_price;
                $amburgers[$i]->count_optionals = count($optionals_items);
                $amburgers[$i]->optionals = $optionals_items;
                $amburgers[$i]->total_price = number_format($total_price, 2, '.', '');
            }

            $info = [
                'count_burger' => count($amburgers),
                'content' =>   $amburgers,
            ];
            return response()->json(
                $info,
                200
            );
    }
}
