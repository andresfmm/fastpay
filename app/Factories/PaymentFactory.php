<?php 

namespace App\Factories;


use ProccessPayment;
use App\Repositories\PaymentRepository;

class PaymentFactory {

    protected $pending  = 'pending';
    protected $paid     = 'paid';
    protected $defeated = 'defeated';
    protected $failed   = 'failed';


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

            
            
            $dataSave = [
                'customer_name'  => $request->name,
                'cpf'            => $request->cpf,
                'description'    => $request->description,
                'valor'          => $request->valor,
                'status'         => $request->status,
                'payment_method' => $request->method,
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