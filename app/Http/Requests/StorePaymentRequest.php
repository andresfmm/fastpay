<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'   => 'required',
            'cpf'             => 'regex:/^[0-9\s]+$/',
            'valor'           => 'required|numeric',
            'method'  => 'required|string'
        ];
    }

     /**
     * Get the messages rules that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        
        return [
            'name.required'   => 'El nombre de usuario es requerido.',
            'cpf.regex'                => 'El cpf debe ser de tipo numerico.',
            'valor.required'           => 'El valor es requerido.',
            'valor.numeric'            => 'El valor de ser de tipo numerico.',
            'method.required'  => 'El metodo de pago es requerido.',
            'method.string'    => 'El metodo de pago debe ser de tipo string.',
        ];  
    }
}
