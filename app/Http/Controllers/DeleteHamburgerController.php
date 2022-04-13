<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hamburger;
use App\Models\Optionals_Burger;

class DeleteHamburgerController extends Controller
{
    /**
     * @OA\Delete(
     *      path="/hamburger/{hamburger_id}/optionals/{optionals_id}", 
     *      tags={"/hamburger"},
     *      summary="Hamburger",
     *      description="Rota responsavel remover itens adicionais!",
     *      security= {{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         description="Parameter example",
     *         in="path",
     *         name="hamburger_id",
     *         required=true,
     *     ),
     *      @OA\Parameter(
     *         description="Parameter example",
     *         in="path",
     *         name="optionals_id",
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
    public function destroyHamburgerUser(Request $request, $hamburger_id, $optionals_id)
    {

        $request["hamburger_id"] = $hamburger_id;
        $request["optionals_id"] = $optionals_id;
        $arrValidate = array(
            'hamburger_id' => 'required | min:1 | integer',
            'optionals_id' => 'required | min:1 | integer',
        );
        $this->validate($request, $arrValidate);

        $StatusBurger = Hamburger::where('users_id', '=', $request->userID)
            ->where('id', '=', $hamburger_id)->get();

        if (count($StatusBurger) < 1 or $StatusBurger[0]->status_orders_id > 1) {
            return response()->json(
                [
                    "error:" => "true",
                    "message" => "Hamburger não pode ser alterado!",
                ],
                409
            );
        }

        $destroyOptionals_Burger = Optionals_Burger::where('optionals_id', '=', $optionals_id)
            ->where('hamburger_id', '=', $hamburger_id)
            ->delete();

        if ($destroyOptionals_Burger == 1) {
            return response()->json([], 200);
        }

        return response()->json(
            [
                "error:" => "true",
                "message" => "Erro ao deletar opcional!",
            ],
            409
        );
    }
}
