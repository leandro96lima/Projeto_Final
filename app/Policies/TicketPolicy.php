<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy extends RolePolicy
{
    /**
     * Determine if the user can view any tickets.
     */
    public function viewAny(User $user)
    {
        return parent::canViewAny($user);
    }

    /**
     * Determine if the user can view a specific ticket.
     */
    public function view(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id || $this->isAdminOrTechnician($user);
    }
}
