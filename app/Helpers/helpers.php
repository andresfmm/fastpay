<?php 

if( !function_exists('responseJson') ) {

    /** 
        *@param bool $status
        *@param int|null $code
        *@param string|null $message
        *@param array $data
        *@param string $type
        *@param array $array
        *@param array $header
        *@param array $errors
        *@return \Illuminate\Http\JsonResponse
    */

    function responseJson( array $dataResponse = [] ) {
        
         $data = array_merge([
             'ok'         => isset($dataResponse['ok'])         ? $dataResponse['ok']         :  '???' , 
             'hasErrors'  => isset($dataResponse['hasErrors'])  ? $dataResponse['hasErrors']  :  '???' , 
             'data'       => isset($dataResponse['data'])       ? $dataResponse['data']       :  '???' ,
             'message'    => isset($dataResponse['message'])    ? $dataResponse['message']    :  '???' ,
             'errors'     => isset($dataResponse['errors'])     ? $dataResponse['errors']     :  '???' ,
             'code'       => isset($dataResponse['code'])       ? $dataResponse['code']       :  '???' ,
             'statusCode' => isset($dataResponse['statusCode']) ? $dataResponse['statusCode'] :  '???' 
         ]);

         return response()->json($data);
    }

    

}


if( !function_exists('calcFeed') ) {

    /** 
        *@param  int $percentaje
        *@param  int $value
        *@return int $result
    */



    function calcFeed( $percentaje, $value ) {
        
         return ( $percentaje * $value ) / 100;
         
    }

    

}