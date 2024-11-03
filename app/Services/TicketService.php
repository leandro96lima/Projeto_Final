<?php
namespace App\Services;

use App\Models\Equipment;
use App\Models\EquipmentApprovalRequest;
use App\Models\Malfunction;
use App\Models\Ticket;
use App\Repositories\MalfunctionRepository;
use App\Repositories\TicketRepository;
use App\Traits\CalculateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketService
{
    use CalculateTime;

    protected $ticketRepository;
    protected $malfunctionRepository;

    public function __construct(TicketRepository $ticketRepository, MalfunctionRepository $malfunctionRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->malfunctionRepository = $malfunctionRepository;
    }

    public function getTickets(Request $request)
    {
        // Obtém a consulta dos tickets sem aplicar a paginação
        $tickets = $this->ticketRepository->getTickets(
            $request->input('status'),
            $request->input('search')
        );

        // Aplica a paginação
        $paginatedTickets = $tickets->paginate(10);

        // Lógica de negócios para calcular o tempo de espera
        foreach ($paginatedTickets as $ticket) {
            $ticket->wait_time = $this->calculateWaitTime($ticket);
        }

        return $paginatedTickets; // Retorna os tickets paginados
    }

    public function showTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->wait_time = $this->calculateWaitTime($ticket);

        return $ticket;
    }

    public function createTicket(array $validatedData)
    {
        $equipment = $this->ticketRepository->findEquipment($validatedData['type'], $validatedData['serial_number']);

        if (!$equipment) {
            throw new \Exception('Equipamento não encontrado.');
        }

        $malfunction = $this->malfunctionRepository->createMalfunction($equipment->id);
        return $this->ticketRepository->createTicket($validatedData, $malfunction->id);
    }

    public function handleEquipmentControllerRequest(Ticket $ticket, $equipmentId): void
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

        session()->forget('from_equipment_controller');
    }

    public function determineTicketStatus(): string
    {
        return session('from_equipment_controller', false) ? 'pending_approval' : 'open';
    }


}
