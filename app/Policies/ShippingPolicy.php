<?php

namespace App\Policies;

use App\Models\Shipping;
use App\Models\User;

class ShippingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view shippings');
    }

    public function view(User $user, Shipping $shipping): bool
    {
        return $user->can('view shippings');
    }

    public function create(User $user): bool
    {
        return $user->can('create shippings');
    }

    public function update(User $user, Shipping $shipping): bool
    {
        return $user->can('update shippings');
    }

    public function delete(User $user, Shipping $shipping): bool
    {
        return $user->can('delete shippings');
    }
}
