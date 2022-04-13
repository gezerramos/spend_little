<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Merchant;


class MerchantsController extends Controller
{
    // /**
    //  * @OA\Post(
    //  *      path="/merchants", 
    //  *      tags={"/merchants"},
    //  *      summary="Merchants",
    //  *      security= {{"bearerAuth": {}}},
    //  *      description="Rota responsavel por criar empresa!",
    //  *     @OA\RequestBody(
    //  *         @OA\MediaType(
    //  *             mediaType="application/json",
    //  *             @OA\Schema( 
    //  *                 required={"name","corporate_name","description","status"},
    //  *                 @OA\Property(
    //  *                     property="name",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="corporate_name",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="description",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="status",
    //  *                     type="number"
    //  *                 ),
    //  *                 example={"name": "Burger2",
    //  *                          "corporate_name": "Burger2 VCa ME", 
    //  *                          "description": "Teste de descrição",
    //  *                          "status": "0 ou 1",
    //  *                          }
    //  *             )
    //  *         )
    //  *     ),
    //  *      @OA\Response (response="200", description="Success"),
    //  *      @OA\Response (response="201", description="Created"),
    //  *      @OA\Response (response="401", description="Unauthorized"),
    //  *      @OA\Response (response="403", description="Forbidden"),
    //  *      @OA\Response (response="404", description="Not Found"),
    //  *      @OA\Response (response="409", description="Conflict"),
    //  *      @OA\Response (response="500", description="Internal Server Error"),
    //  * )
    //  */
    public function createMerchant(Request $request)
    {

        $this->validate($request, array(
            'name' => 'required|min:6|max:100 | string |unique: merchants, name',
            'corporate_name' => 'required|min:6|max:100 | string',
            'description' => 'required|min:6|max:100 | string',
            'status' => 'required | min:0 | max:1 | integer',
        ));

        $merchant = new Merchant;
        $merchant->name = $request->name;
        $merchant->corporate_name = $request->corporate_name;
        $merchant->description = $request->description;
        $merchant->status = $request->status;
        $merchant->user_id = $request->userID;
        $merchant->save();


        return response()->json(
            'Dados salvos com sucesso!',
            201
        );
    }

    // /**
    //  * @OA\Patch(
    //  *      path="/merchants/{id}", 
    //  *      tags={"/merchants"},
    //  *      summary="Merchants",
    //  *      security= {{"bearerAuth": {}}},
    //  *      description="Rota responsavel por criar empresa!",
    //  *      @OA\Parameter(
    //  *         description="Parameter example",
    //  *         in="path",
    //  *         name="id",
    //  *         required=true,
    //  *     ),
    //  *     @OA\RequestBody(
    //  *         @OA\MediaType(
    //  *             mediaType="application/json",
    //  *             @OA\Schema( 
    //  *                 required={"name","corporate_name","description","status"},
    //  *                 @OA\Property(
    //  *                     property="name",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="corporate_name",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="description",
    //  *                     type="string"
    //  *                 ),
    //  *                 @OA\Property(
    //  *                     property="status",
    //  *                     type="number"
    //  *                 ),
    //  *                 example={"name": "Burger2",
    //  *                          "corporate_name": "Burger2 VCa ME", 
    //  *                          "description": "Teste de descrição",
    //  *                          "status": "0 ou 1",
    //  *                          }
    //  *             )
    //  *         )
    //  *     ),
    //  *      @OA\Response (response="200", description="Success"),
    //  *      @OA\Response (response="201", description="Created"),
    //  *      @OA\Response (response="401", description="Unauthorized"),
    //  *      @OA\Response (response="403", description="Forbidden"),
    //  *      @OA\Response (response="404", description="Not Found"),
    //  *      @OA\Response (response="409", description="Conflict"),
    //  *      @OA\Response (response="500", description="Internal Server Error"),
    //  * )
    //  */
    public function updateMerchant(Request $request, $id)
    {
        $this->validate($request, array(
            'name' => 'min:6|max:100 | string',
            'corporate_name' => 'min:6|max:100 | string',
            'description' => 'min:6|max:100 | string',
            'status' => 'min:0 | max:1 | integer',
        ));


        $merchant = Merchant::find($id);
        if (!$merchant) {
            return response()->json([
                "error:" => "true",
                "message" => "Empresa não encontrado!",
            ], 409);
        }

        //validando apenas o que esta na regra
        $requestEquals = array();
        foreach ($request->all() as $input => $value) {
            if (array_key_exists($input, $request->rules())) {
                $requestEquals[$input] = $value;
            }
        }

        $merchant->update($requestEquals);


        return response()->json(
            'Dados salvos com sucesso!',
            201
        );
    }

    //  /**
    //  * @OA\Get(
    //  *      path="/merchants", 
    //  *      tags={"/merchants"},
    //  *      summary="Merchant",
    //  *      description="Rota responsavel por listar todos os usuarios!",
    //  *      security= {{"bearerAuth": {}}},
    //  *      @OA\Response (
    //  *          response="200", description="Success"),
    //  *      @OA\Response (response="201", description="Created"),
    //  *      @OA\Response (response="401", description="Unauthorized"),
    //  *      @OA\Response (response="403", description="Forbidden"),
    //  *      @OA\Response (response="404", description="Not Found"),
    //  *      @OA\Response (response="409", description="Conflict"),
    //  *      @OA\Response (response="500", description="Internal Server Error"),
    //  * )
    //  */
    public function allMerchant(Request $request)
    {

        try {
            $merchant = Merchant::all([
                'id',
                'name',
                'corporate_name',
                'description',
                'status',
                'created_at',
                'updated_at'
            ]);

            $info = [
                'count' => count($merchant),
                'content' => $merchant,
            ];
            return response()->json(
                $info,
                200
            );
        } catch (\Throwable  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], $e->status);
        }
    }
}
