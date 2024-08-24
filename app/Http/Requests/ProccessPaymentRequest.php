<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProccessPaymentRequest extends FormRequest
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
            'id' => 'required|uuid'
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
            'id.required'  => 'The id is required',
            'id.uuid'      => 'The id must of type uuid',
        ];  
    }
}
