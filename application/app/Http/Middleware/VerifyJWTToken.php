<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Closure;
use JWTAuth;

class VerifyJWTToken
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {                
                return response()->json(['message' => 'Token Validation', 'errors'=> 'Token Expired'],  $e->getStatusCode());
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {                
                return response()->json(['message' => 'Token Validation', 'errors'=> 'Token Invalid'],  $e->getStatusCode());
            }else{
                return response()->json(['message' => 'Token Validation', 'errors'=> 'Token is Required']);
            }
        }
        
       return $next($request);
    }

}