<?php

namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentApprovalRequest;
use App\Models\Malfunction;
use App\Models\Ticket;
use App\Repositories\TicketRepository; // Importe o repositório
use App\Traits\CalculateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketService
{
    use CalculateTime;

    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }


    public function getTickets(Request $request)
    {
        $query = Ticket::with(['technician.user', 'malfunction']);

        // Filtra por status se estiver presente
        if ($request->filled('status')) {
            $query->withStatus($request->input('status'));
        }

        // Filtra por pesquisa se houver
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        $tickets = $query->paginate(10);

        // Calcula o tempo de espera para cada ticket usando o método do trait
        $tickets->each(function($ticket) {
            if ($ticket->malfunction) {
                $ticket->wait_time = $this->calculateWaitTime($ticket);
            }
        });

        return $tickets;
    }

    public function createTicket(array $validatedData)
    {
        // Encontre o equipamento
        $equipment = $this->ticketRepository->findEquipment($validatedData['type'], $validatedData['serial_number']);

        if (!$equipment) {
            throw new \Exception('Equipamento não encontrado.');
        }

        // Crie uma nova falha
        $malfunction = $this->ticketRepository->createMalfunction($equipment->id);

        // Crie o ticket
        return $this->ticketRepository->createTicket($validatedData, $malfunction->id);
    }

    public function handleEquipmentControllerRequest(Ticket $ticket, $equipmentId): void
    {
        if (!session('from_equipment_controller')) {
            return;
        }

        // Aqui a lógica de negócios para lidar com a requisição do controlador de equipamento
        $equipmentApprovalRequest = EquipmentApprovalRequest::where('equipment_id', $equipmentId)
            ->where('status', 'pending')
            ->first();

        if ($equipmentApprovalRequest) {
            $equipmentApprovalRequest->ticket_id = $ticket->id;
            $equipmentApprovalRequest->save();
        }

        session()->forget('from_equipment_controller'); // Limpar a sessão
    }

    public function determineTicketStatus(): string
    {
        return session('from_equipment_controller', false) ? 'pending_approval' : 'open';
    }
}
