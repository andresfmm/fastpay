<?php 

namespace App\Payment;

class ProccessPayment 
{

    protected $statusError = array(
        'defeated',
        'failed',
    );

    protected $paid = 'paid';

    public function proccess( object $payment = null )
    {

        try {

            $percentageOfProbability = $this->getPercentageOfProbability();

            if ( $percentageOfProbability >= 70 ) {

                $key = array_rand($this->statusError);

                $payment->status = $this->statusError[$key];

                $response = array(
                    'ok'         => true,
                    'hasErrors'  => false,
                    'data'       => $payment,
                    'message'    => 'Data proccessed error',
                    'errors'     => [''],
                    'statusCode' => 200
                );
                
                return responseJson($response);

            }

            $payment->status = $this->paid;

            $response = array(
                'ok'         => true,
                'hasErrors'  => false,
                'data'       => $payment,
                'message'    => 'Data proccessed successfull',
                'errors'     => [''],
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
                'statusCode' => 500
            );
            
            return responseJson($response);

        }

    }

    protected function getPercentageOfProbability()
    {
        return rand(1, 100);
    }



}