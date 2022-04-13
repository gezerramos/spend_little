<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hamburger;

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

        $request['hamburger_id'] = $hamburger_id;
        $request['user_id'] = $user_id;
        $request['status_id'] = $status_id;

        $this->validate($request, array(
            'hamburger_id' => 'required| min:0 | integer |exists:hamburger,id,users_id,'.$user_id,
            'status_id' => 'required | min:0 | integer|exists:status_orders,id',
            'user_id' => 'required | min:0 | integer|exists:users,id',
        ));

 
        $StatusBurger = Hamburger::where('id', '=', $hamburger_id);

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
    }
}
