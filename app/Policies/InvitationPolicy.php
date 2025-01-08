<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Models\User;

class InvitationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view invitations');
    }

    public function view(User $user, Invitation $invitation): bool
    {
        return $user->can('view invitations');
    }

    public function create(User $user): bool
    {
        return $user->can('create invitations');
    }

    public function update(User $user, Invitation $invitation): bool
    {
        return $user->can('update invitations');
    }

    public function delete(User $user, Invitation $invitation): bool
    {
        return $user->can('delete invitations');
    }
}
