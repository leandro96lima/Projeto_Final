<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    const ADMIN = 'Admin';
    const TECHNICIAN = 'Technician';

    private function isAdminOrTechnician(User $user): bool
    {
        return in_array($user->getType(), [self::ADMIN, self::TECHNICIAN]);
    }

    /**
     * Determine if the user can view any tickets.
     */
    public function viewAny(User $user)
    {
        return $this->isAdminOrTechnician($user);
    }

    /**
     * Determine if the user can view a specific ticket.
     */
    public function view(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id || $this->isAdminOrTechnician($user);
    }
}

