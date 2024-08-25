<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
{

    // use RefreshDatabase;

    public $idPayment = '9cda5ec5-decc-4a0c-9730-51b17a55fc61';

   
    
    
    public function test_aplication_create_payment(): void
    {

        $user = User::where('email', env('USER_TEST_UNIT'))->first();
        $token = JWTAuth::fromUser($user);

       $this->withHeaders(['Authorization'=>'Bearer '.$token]);

        $dataSave = [
            "name"           => "test",
            "cpf"            => "46545",
            "description"    => "dsad",
            "value"          => 5000,
            "status"         => "pending",
            "payment_method" => "ticket"
        ];
        
        $response = $this->post('/api/v1/payment', $dataSave );

        $response->assertStatus(200);

        $this->idPayment = $response->baseResponse->original['data']['id'];
       
        $response->assertJson([
                "ok"        => true,
                "hasErrors" => false,
                "data" => [],
                "message" => "Payment created.",
                "errors" => array(),
                "code" => "PS-01",
                "statusCode" => 201
            ]);
    }



    

    public function test_aplication_get_payment_by_id(): void
    {

        $user = User::where('email', env('USER_TEST_UNIT'))->first();
        $token = JWTAuth::fromUser($user);

        $this->withHeaders(['Authorization'=>'Bearer '.$token]);

        $idPayment = [ 
            "id" => $this->idPayment 
        ];

        $response = $this->post('/api/v1/payments', $idPayment);

        $response->assertStatus(200);

        $response->assertJson([
                'ok'         => true,
                'hasErrors'  => false,
                'data'       => [],
                'message'    => 'Detail payment.',
                'errors'     => [],
                'code'       => 'PS-01',
                "statusCode" => 302
            ]);

    }



    public function test_aplication_get_payments(): void
    {

        $user = User::where('email', env('USER_TEST_UNIT'))->first();
        $token = JWTAuth::fromUser($user);

        $this->withHeaders(['Authorization'=>'Bearer '.$token]);
        
        $response = $this->get('/api/v1/payments');

        $response->assertStatus(200);

        $response->assertJson([
                "ok"        => true,
                "hasErrors" => false,
                "data" => [],
                "message" => "List of payments.",
                "errors" => array(),
                "code" => "PS-01",
                "statusCode" => 302
            ]);
    }


    

}
