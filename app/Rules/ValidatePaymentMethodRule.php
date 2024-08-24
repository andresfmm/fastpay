<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidatePaymentMethodRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
       
        if ( !in_array(strtolower($value), PAYMENT_METHODS ) ) {
             $fail('The :attribute must be type pix ticket or bank transfer ');
        }
        
    }
}
