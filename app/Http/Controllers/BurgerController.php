<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hamburger;
use App\Models\Optionals_Burger;

class BurgerController extends Controller
{

    /**
     * @OA\Get(
     *      path="/admin/hamburger/{status}", 
     *      tags={"/admin/hamburger"},
     *      summary="Hamburger : admin",
     *      description="Rota responsavel por listar todas hamburgers!",
     *      security= {{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         description="Parameter example",
     *         in="path",
     *         name="status",
     *         required=true,
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
    public function allHamburgerUser(Request $request, $status)
    {


            $amburgers = Hamburger::innerjoinHamburgerInfo($status);
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
