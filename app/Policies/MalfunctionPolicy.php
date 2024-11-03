<?php

namespace App\Policies;

use App\Models\Malfunction;
use App\Models\User;

class MalfunctionPolicy extends RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user): bool
    {
        return parent::canViewAny($user);
    }

    public function view(User $user, Malfunction $malfunction): bool
    {
        return $user->id === $malfunction->technician_id || $this->isAdminOrTechnician($user);
    }

    /**
     * Determine if the user can view a specific ticket.
     */

    public function delete(User $user)
    {
        return  $this->isAdmin($user);
    }

    public function update(User $user)
    {
        return  $this->isAdminOrTechnician($user);
    }
}
