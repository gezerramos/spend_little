<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(url="https://spendlittle.herokuapp.com/api/v1", description="API(Production)")
 * @OA\Server(url="http://localhost:8000/api/v1", description="API(Produção)")
 * @OA\Info(
 *      title="Spend Little", 
 *      version="0.1",
 *      description="Essa API foi desenvolvida para manipular Spend Little",
 *      @OA\contact(
 *          email="gezerramo@gmail.com")
 * )
 * @OA\SecurityScheme(
 *      type= "http",
 *      scheme= "bearer",
 *      securityScheme="bearerAuth"
 * )
 */

class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
