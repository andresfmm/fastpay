<?php

namespace App\Http\Requests;

use App\Rules\ValidatePaymentMethodRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name'            => 'required',
            'cpf'             => 'regex:/^[0-9\s]+$/',
            'value'           => 'required|numeric',
            'payment_method'  => 'required|string',
            'payment_method'  => [ new ValidatePaymentMethodRule],
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
            'name.required'    => 'Username is required.',
            'cpf.regex'        => 'The CPF must be numeric.',
            'value.required'   => 'The value is required.',
            'value.numeric'    => 'The value must be of numeric type.',
            'payment_method.required'  => 'Payment method is required.',
            'payment_method.string'    => 'The payment method must be of type string.',
        ];  
    }
}
