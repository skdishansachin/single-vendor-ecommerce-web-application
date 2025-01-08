<?php

namespace App\Policies;

use App\Models\Collection;
use App\Models\User;

class CollectionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view collections');
    }

    public function view(User $user, Collection $collection): bool
    {
        return $user->can('view collections');
    }

    public function create(User $user): bool
    {
        return $user->can('create collections');
    }

    public function update(User $user, Collection $collection): bool
    {
        return $user->can('update collections');
    }

    public function delete(User $user, Collection $collection): bool
    {
        return $user->can('delete collections');
    }
}
