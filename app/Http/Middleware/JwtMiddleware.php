<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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

            $user = auth()->user();

            if ( empty($user) ) {
                 
                $response = array(
                    'ok'         => false,
                    'hasErrors'  => true,
                    'data'       => [],
                    'message'    => 'User Unauthenticated.',
                    'errors'     => ['Unauthorized'],
                    'code'       => 'PS-04',
                    'statusCode' => HTTP_UNAUTHORIZED
                );
                
                return responseJson($response);

            }

            
            $token = JWTAuth::getToken();
            
            if (!$token) {

                $response = array(
                    'ok'         => false,
                    'hasErrors'  => true,
                    'data'       => [],
                    'message'    => 'User Unauthenticated.',
                    'errors'     => ['Unauthorized'],
                    'code'       => 'PS-04',
                    'statusCode' => HTTP_UNAUTHORIZED
                );
                
                return responseJson($response);
            }

        } catch (Exception $e) {

            Log::info(json_encode($e));
            
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {

                $response = array(
                    'ok'         => false,
                    'hasErrors'  => true,
                    'data'       => [],
                    'message'    => 'Token is Invalid.',
                    'errors'     => ['Token is Invalid.'],
                    'code'       => 'PS-05',
                    'statusCode' => HTTP_UNAUTHORIZED
                );
                
                return responseJson($response);

            } 
            
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                
                $response = array(
                    'ok'         => false,
                    'hasErrors'  => true,
                    'data'       => [],
                    'message'    => 'Token is Expired.',
                    'errors'     => ['Token is Expired.'],
                    'code'       => 'PS-05',
                    'statusCode' => HTTP_UNAUTHORIZED
                );
                
                return responseJson($response);

            } 

                
            $response = array(
                'ok'         => false,
                'hasErrors'  => true,
                'data'       => [],
                'message'    => 'Authorization Token not found.',
                'errors'     => ['Authorization Token not found.'],
                'code'       => 'PS-05',
                'statusCode' => HTTP_UNAUTHORIZED
            );
            
            return responseJson($response);
            
        }

        // $response = array(
        //     'ok'         => false,
        //     'hasErrors'  => true,
        //     'data'       => [],
        //     'message'    => 'User Unauthenticated.',
        //     'errors'     => ['Unauthorized'],
        //     'code'       => 'PS-04',
        //     'statusCode' => HTTP_UNAUTHORIZED
        // );
        
        // return responseJson($response);
        return $next($request);
    }
}
