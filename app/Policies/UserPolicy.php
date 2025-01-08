<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view users');
    }

    public function view(User $user): bool
    {
        return $user->can('view users');
    }

    public function updateAccess(User $user, User $customer): bool
    {
        return $user->can('update users access') && $user->id !== $customer->id && ! $customer->hasRole('admin');
    }
}
