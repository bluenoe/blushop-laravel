<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VietnamPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Must be numeric
        if (!is_numeric($value)) {
            $fail("The :attribute must be a number.");
            return;
        }

        // Must be exactly 9 digits
        if (!preg_match('/^[0-9]{9}$/', $value)) {
            $fail("The :attribute must be 9 digits.");
            return;
        }

        // Optional: Check valid prefixes (3, 5, 7, 8, 9)
        // 03x, 05x, 07x, 08x, 09x are valid.
        // Since we stripped the 0, the first digit must be 3, 5, 7, 8, or 9.
        $firstDigit = substr($value, 0, 1);
        if (!in_array($firstDigit, ['3', '5', '7', '8', '9'])) {
            $fail("The :attribute contains an invalid prefix.");
        }
    }
}
