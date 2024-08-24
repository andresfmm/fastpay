<?php 

namespace App\Factories;

use Illuminate\Support\Facades\Auth;
use App\Repositories\PaymentRepository;

class UserFactory 
{

    public function login($request)
    {
        
        try {
            
            if (!$token = auth()->attempt($request->only('email', 'password'))) { 

                $response = array(
                    'ok'         => true,
                    'hasErrors'  => true,
                    'data'       => [],
                    'message'    => 'User or password incorrect',
                    'errors'     => ['User or password incorrect'],
                    'statusCode' => 200
                );
            
                return responseJson($response);
            }
           
            $response = array(
                'ok'         => true,
                'hasErrors'  => false,
                'data'       => $token,
                'message'    => 'Welcome to the system',
                'errors'     => [],
                'statusCode' => 200
            );
        
            return responseJson($response);

        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    public function logout()
    {

        try {
 
            auth()->logout();

            $response = array(
                'ok'         => true,
                'hasErrors'  => false,
                'data'       => [],
                'message'    => 'Successfully logged out',
                'errors'     => [],
                'statusCode' => 200
            );
        
            return responseJson($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
}
