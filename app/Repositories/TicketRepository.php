<?php

namespace App\Repositories;

use App\Models\Equipment;
use App\Models\Malfunction;
use App\Models\Ticket;
use App\Models\EquipmentApprovalRequest;
use Illuminate\Http\Request;

class TicketRepository extends BaseRepository
{
    public function __construct(Ticket $ticket)
    {
        parent::__construct($ticket);
    }

    public function getTickets($status = null, $search = null)
    {
        $query = Ticket::with(['technician.user', 'malfunction']);

        if ($status) {
            $query->withStatus($status);
        }

        if ($search) {
            $query->search($search);
        }

        return $query;
    }

    public function findTicket($id)
    {
        return Ticket::with(['technician.user', 'malfunction'])->findOrFail($id);
    }

    public function findEquipment($type, $serialNumber)
    {
        return Equipment::where('type', $type)
            ->where('serial_number', $serialNumber)
            ->first();
    }

    public function createTicket($validatedData, $malfunctionId): Ticket
    {
        $ticketData = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'open_date' => now(),
            'malfunction_id' => $malfunctionId,
            'user_id' => auth()->id(),
            'status' => 'open',
            'wait_time' => null,
        ];

        return $this->create($ticketData);
    }

    public function updateTicketStatus(Ticket $ticket, array $validatedData)
    {
        $ticketData = [
            'status' => $validatedData['status'],
            'urgent' => $validatedData['urgent'],
        ];

        // Atualiza as datas com base no status
        if ($validatedData['status'] === 'in_progress') {
            $ticketData['progress_date'] = now();
            $ticketData['close_date'] = null; // Limpa o close_date
        } elseif ($validatedData['status'] === 'closed') {
            $ticketData['close_date'] = now();
        }

        $ticket->update($ticketData);
    }
}
