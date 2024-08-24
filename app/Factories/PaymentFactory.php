<?php 

namespace App\Factories;

use App\Repositories\PaymentRepository;

class PaymentFactory {


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
}