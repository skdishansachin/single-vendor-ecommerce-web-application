<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckCustomerRole implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where('email', $value)->first();

        if (! $user || ! $user->hasRole(['customer'])) {
            $fail(__('auth.failed'));
        }
    }
}
