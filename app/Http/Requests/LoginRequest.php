<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'    => 'required|email',
            'password' => 'required'
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
            'email.required'    => 'The email is required',
            'email.email'       => 'The email is must be type email',
            'password.required' => 'The password is required',
        ];  
    }
}
