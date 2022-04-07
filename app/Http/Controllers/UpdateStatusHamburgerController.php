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

class UpdateStatusHamburgerController extends Controller
{

    //user admin
    /**
     * @OA\Patch(
     *      path="/admin/hamburger/{hamburger_id}/user/{user_id}/status/{status_id}", 
     *      tags={"/admin/hamburger"},
     *      summary="Hamburger : Admin",
     *      description="Rota responsavel cancelar pedido do cliente!",
     *      security= {{"bearerAuth": {}}},
     *      @OA\Parameter(
     *         description="Parameter example 0",
     *         in="path",
     *         name="hamburger_id",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter example 0",
     *         in="path",
     *         name="user_id",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         description="Parameter example 0",
     *         in="path",
     *         name="status_id",
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
    public function updateStatusHamburgerAdmin(Request $request, $hamburger_id, $user_id, $status_id)
    {
        try {

            function error($value)
            {
                throw new \ErrorException($value . ' inválido!');
            }

            is_numeric($hamburger_id) ?: error('hamburger_id');
            is_numeric($status_id) ?: error('status_id');
            is_numeric($user_id) ?: error('user_id');

            count(Status_Order::where('id', '=', $status_id)->get()) > 0 ?: 
            error('status_id');

            $StatusBurger = Hamburger::where('users_id', '=',  $user_id)
                ->where('id', '=', $hamburger_id);

            if (count($StatusBurger->get()) < 1) {
                return response()->json(
                    [
                        "error:" => "true",
                        "message" => "Hamburger não existe!",
                    ],
                    409
                );
            }

            $cancelBurger = $StatusBurger->update(array(
                'status_orders_id' => $status_id
            ));

            if ($cancelBurger == 1) {
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
