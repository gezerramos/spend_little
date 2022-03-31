<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use \Tymon\JWTAuth\Http\Middleware\Authenticate;
use \Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticMD extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    /* public function handle(Request $request, Closure $next)
    {
        //return Response($request->header('Authorization'));
        $request->teste= 'teste';
        return $next($request);
    } */
    public function handle($request, Closure $next)
    {
        try {

            $this->authenticate($request);

            $token = JWTAuth::getToken();
            $apy = JWTAuth::getPayload($token)->toArray();

            $request["userID"] =  $apy['sub'];

            return $next($request);
        } catch (\Exception  $e) {

            return response()->json([
                "error:" => "true",
                "message" => $e->getMessage(),
            ], 401);
        }
    }
}
