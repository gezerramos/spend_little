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

class DeleteHamburgerController extends Controller
{
    /**
     * @OA\Get(
     *      path="/hamburger/{id}/me", 
     *      tags={"/hamburger"},
     *      summary="Damburger",
     *      description="Rota responsavel recuperar usuario!",
     *      security= {{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         description="Parameter example",
     *         in="path",
     *         name="id",
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
    public function destroyHamburgerUser($hamburger_id, $optionals_id)
    {
        try {
            function error($value)
            {
                throw new \ErrorException($value . ' inválido!');
            }
            is_numeric($optionals_id) ?: error('optionals_id');
            is_numeric($hamburger_id) ?: error('hamburger_id');

            $StatusBurger = Hamburger::where('status_orders_id', '!=', 1)
                ->where('id', '=', $hamburger_id)->get();

            if (count($StatusBurger) > 0) {
                return response()->json(
                    [
                        "error:" => "true",
                        "message" => "Hamburger está em preparo!",
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
        } catch (\Throwable  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], 500);
        }
    }
}
