<?php

namespace App\Repositories;

use App\Models\Equipment;
use App\Models\Malfunction;
use App\Models\Ticket;
use App\Models\EquipmentApprovalRequest;
use Illuminate\Http\Request;

class TicketRepository
{
    public function validateRequest(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
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
        $ticket = new Ticket();
        $ticket->title = $validatedData['title'];
        $ticket->description = $validatedData['description'];
        $ticket->open_date = now();
        $ticket->malfunction_id = $malfunctionId;
        $ticket->user_id = auth()->id();
        $ticket->status = $this->determineTicketStatus();
        $ticket->wait_time = null; // Ou ajuste conforme necessário
        $ticket->save();

        return $ticket;
    }

    public function determineTicketStatus(): string
    {
        return session('from_equipment_controller', false) ? 'pending_approval' : 'open';
    }

    public function handleEquipmentControllerRequest($ticket, $equipmentId): void
    {
        if (!session('from_equipment_controller')) {
            return;
        }

        $equipmentApprovalRequest = EquipmentApprovalRequest::where('equipment_id', $equipmentId)
            ->where('status', 'pending')
            ->first();

        if ($equipmentApprovalRequest) {
            $equipmentApprovalRequest->ticket_id = $ticket->id;
            $equipmentApprovalRequest->save();
        }

        session()->forget('from_equipment_controller'); // Limpar a sessão
    }

    public function redirectBackWithError($key, $message): \Illuminate\Http\RedirectResponse
    {
        return redirect()->back()->withErrors([$key => $message])->withInput();
    }
}
