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
                    'code'       => 'PS-02',
                    'statusCode' => HTTP_OK
                );
            
                return responseJson($response);
            }
           
            $response = array(
                'ok'         => true,
                'hasErrors'  => false,
                'data'       => $token,
                'message'    => 'Welcome to the system',
                'errors'     => [],
                'code'       => 'PS-01',
                'statusCode' => HTTP_OK
            );
        
            return responseJson($response);

        } catch (\Throwable $th) {
            
            $response = array(
                'ok'         => false,
                'hasErrors'  => true,
                'data'       => [],
                'message'    => 'Consult your system administrator.',
                'errors'     => ['Consult your system administrator.'],
                'code'       => 'ES-01',
                'statusCode' => HTTP_INTERNAL_SERVER_ERROR
            );
            
            return responseJson($response);

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
                'code'       => 'PS-01',
                'statusCode' => 200
            );
        
            return responseJson($response);

        } catch (\Throwable $th) {
            
            $response = array(
                'ok'         => false,
                'hasErrors'  => true,
                'data'       => [],
                'message'    => 'Consult your system administrator.',
                'errors'     => ['Consult your system administrator.'],
                'code'       => 'ES-01',
                'statusCode' => HTTP_INTERNAL_SERVER_ERROR
            );
            
            return responseJson($response);

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
