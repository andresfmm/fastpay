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
                'message'    => 'Listado de pagos',
                'errors'     => [],
                'statusCode' => 200
            );
            
            return responseJson($response);

        } catch (\Throwable $th) {
            throw $th;
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
                'message'    => 'Detail payment',
                'errors'     => [],
                'statusCode' => 200
            );
            
            return responseJson($response);

        } catch (\Throwable $th) {
            //throw $th;
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
                'statusCode' => 200
            );
            
            return responseJson($response);

        } catch (\Throwable $th) {
            throw $th;
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
                    'statusCode' => 200
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
                    'statusCode' => 200
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
                'message'    => 'Payment proccessed',
                'errors'     => [],
                'statusCode' => 200
            );
            
            return responseJson($response);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}