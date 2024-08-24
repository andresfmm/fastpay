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


    // function responseJson(bool $status = true, bool $hasErrors = false, array $data = [], string $message = '', array $errors = [], $statusCode = 200)
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