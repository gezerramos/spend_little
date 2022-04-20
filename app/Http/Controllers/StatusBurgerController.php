<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Status_Order;

class StatusBurgerController extends Controller
{
    /**
     * @OA\Get(
     *      path="/admin/status_orders", 
     *      tags={"/admin/status_orders"},
     *      summary="status_orders",
     *      description="Rota responsavel por listar todos niveis de acesso!",
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
    public function allStatusOrders(Request $request)
    {

        $statusOrders = Status_Order::all([
            'id',
            'name'
        ]);

        $info = [
            'count' => count($statusOrders),
            'content' => $statusOrders,
        ];
        return response()->json(
            $info,
            200
        );
    }
}
