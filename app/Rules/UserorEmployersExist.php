<?php

namespace App\Rules;

use Closure;
use App\Models\User;
use App\Models\Employer;
use Illuminate\Contracts\Validation\ValidationRule;

class UserorEmployersExist implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!User::where("email", $value)->first() && !Employer::where("email", $value)->first()) {
            $fail("Cet email est incorrect !");
        }
    }
}
