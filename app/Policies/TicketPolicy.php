<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user)
    {
        // Verifica se o usuário é um admin ou technician
        return $user->getType() === 'Admin' || $user->getType() === 'Technician';
    }

    public function view(User $user, Ticket $ticket)
    {
        // Usuários normais só podem ver seus próprios tickets
        return $user->id === $ticket->user_id || $this->viewAny($user);
    }
}
