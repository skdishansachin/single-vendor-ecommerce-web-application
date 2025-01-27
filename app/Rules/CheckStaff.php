<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckStaff implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where('email', $value)->first();
        $roles = ['product', 'collection', 'order', 'user', 'admin'];

        if (! $user || ! $user->hasRole($roles)) {
            $fail(__('auth.failed'));
        }
    }
}
