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

    public function findEquipment($type, $serialNumber)
    {
        return Equipment::where('type', $type)
            ->where('serial_number', $serialNumber)
            ->first();
    }

    public function createMalfunction($equipmentId): Malfunction
    {
        $malfunction = new Malfunction();
        $malfunction->equipment_id = $equipmentId;
        $malfunction->save();

        return $malfunction;
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
}
