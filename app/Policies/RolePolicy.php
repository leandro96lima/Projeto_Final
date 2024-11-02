<?php

namespace App\Policies;

use App\Models\User;

class RolePolicy
{
    const ADMIN = 'Admin';
    const TECHNICIAN = 'Technician';

    protected function isAdminOrTechnician(User $user): bool
    {
        return in_array($user->getType(), [self::ADMIN, self::TECHNICIAN]);
    }

    public function canViewAny(User $user)
    {
        return $this->isAdminOrTechnician($user);
    }
}
