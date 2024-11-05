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

    public function getTicketsFromDb($status = null, $search = null, $sort = null, $direction = "asc")
    {
        $query = Ticket::with(['technician.user', 'malfunction']);

        if ($status) $query->withStatus($status);
        if ($search) $query->search($search);
        if ($sort) $query->sortBy($sort, $direction);

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
    public function addTicketToDb($validatedData, $malfunctionId): Ticket
    {
        $ticket = new Ticket();
        $ticket->title = $validatedData['title'];
        $ticket->description = $validatedData['description'];
        $ticket->user_id = auth()->id();
        $ticket->open_date = now();
        $ticket->malfunction_id = $malfunctionId;

        // Verifica se a requisição veio do EquipmentController
        $ticket->status = session('from_equipment_controller', false) ? 'pending_approval' : 'open';
        $ticket->wait_time = null; // Ou ajuste conforme necessário
        $ticket->save();

        return $ticket;


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
