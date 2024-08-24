<?php 

namespace App\Factories;


use ProccessPayment;
use Illuminate\Support\Facades\Log;
use App\Repositories\PaymentRepository;
use App\Repositories\UserRepository;

use Tymon\JWTAuth\Facades\JWTAuth;

class PaymentFactory {

    protected $pending  = 'pending';
    protected $paid     = 'paid';
    protected $defeated = 'defeated';
    protected $failed   = 'failed';

    protected $validPaymentMethods = PAYMENT_METHODS;

    protected $fee = array(
        'pix'           => 1.5,
        'ticket'        => 2,
        'bank transfer' => 4
    );


    public function getAll() 
    {

        try {
            
            $listOfPayments = app(PaymentRepository::class)->all();

            $response = array(
                'ok'         => true,
                'hasErrors'  => false,
                'data'       => $listOfPayments,
                'message'    => 'List of payments.',
                'errors'     => [],
                'code'       => 'PS-01',
                'statusCode' => HTTP_FOUND
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


    public function getById($id)
    {

        try {
            
            $payment = app(PaymentRepository::class)->getById($id);
        
            $response = array(
                'ok'         => true,
                'hasErrors'  => false,
                'data'       => $payment,
                'message'    => 'Payment detail.',
                'errors'     => [],
                'code'       => 'PS-01',
                'statusCode' => HTTP_FOUND
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


    public function save($request)
    {

        try {

            $resultCharge = $this->chargeFee($request);

            if ( !$resultCharge->getData()->ok && $resultCharge->getData()->hasErrors ) {
                 
                return $resultCharge;
            }
            
            $dataSave = [
                'customer_name'  => $request->name,
                'cpf'            => $request->cpf,
                'description'    => $request->description,
                'valor'          => $resultCharge->getData()->data,
                'status'         => $request->status,
                'payment_method' => $request->payment_method,
            ];
            
            $payment = app(PaymentRepository::class)->save($dataSave);

            $response = array(
                'ok'         => true,
                'hasErrors'  => false,
                'data'       => $payment,
                'message'    => 'Detail payment',
                'errors'     => [],
                'code'       => 'PS-01',
                'statusCode' => HTTP_CREATED
            );

            Log::info("The paymenth  {$payment} original value {$request->value} and value after a {$this->fee[$payment->payment_method]}% of discount {$resultCharge->getData()->data} was created success.");
       
            return responseJson($response);

        } catch (\Throwable $th) {
            throw $th;
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


    protected function chargeFee($request)
    {

        try {

                $value          = $request->value;

                $payment_method = $request->payment_method;
                
                if ( !in_array(strtolower($payment_method), PAYMENT_METHODS ) ) {

                    $response = array(
                        'ok'         => false,
                        'hasErrors'  => true,
                        'data'       => [],
                        'message'    => 'The payment method is not valid.',
                        'errors'     => ['Invalid payment method.'],
                        'code'       => 'ES-06',
                        'statusCode' => HTTP_UNPROCESSABLE_ENTITY
                    );
                    
                    return responseJson($response);
                    
                }


                $fee = $this->fee[$payment_method];

                $valueDesc = calcFeed($fee, $value);

                $newValue = $value - $valueDesc;

                $response = array(
                    'ok'         => true,
                    'hasErrors'  => false,
                    'data'       => $newValue,
                    'message'    => '',
                    'errors'     => [],
                    'code'       => 'ES-01',
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

    


    public function proccess($request)
    {

        try {

            $paymentId = $request->id;

            $payment = app(PaymentRepository::class)->getById($paymentId);

            if ( empty($payment) ) {
                
                $response = array(
                    'ok'         => true,
                    'hasErrors'  => false,
                    'data'       => [],
                    'message'    => 'No payment found.',
                    'errors'     => [],
                    'code'       => 'PS-02',
                    'statusCode' => HTTP_OK
                );
                
                return responseJson($response);
            }

            if ( isset($payment->status) && $payment->status != $this->pending ) {
                 
                $response = array(
                    'ok'         => true,
                    'hasErrors'  => false,
                    'data'       => [],
                    'message'    => 'This payment has already been processed.',
                    'errors'     => [],
                    'code'       => 'PS-03',
                    'statusCode' => HTTP_OK
                );
                
                return responseJson($response);

            }

            $paymentProccessed = ProccessPayment::proccess($payment);


            if ( isset($paymentProccessed->getData()->ok) && !$paymentProccessed->getData()->ok ) {

                return $paymentProccessed; 

            }

            $newStatus = $paymentProccessed->getData()->data->status;

            $payment->update([
                'status' => $newStatus
            ]);

            // check n+1
            $currentUser = JWTAuth::user();

            $user = app(UserRepository::class)->getById($currentUser->id);

            $user->update([
                'balance' => $user->balance + $payment->valor
            ]);

            $response = array(
                'ok'         => true,
                'hasErrors'  => false,
                'data'       => $payment,
                'message'    => 'Payment proccessed.',
                'errors'     => [],
                'code'       => 'PS-01',
                'statusCode' => HTTP_CREATED
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
}