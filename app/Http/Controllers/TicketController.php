<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Ticket;
use App\Repositories\TicketRepository;
use App\Traits\CalculateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Enums\EquipmentType;

class TicketController extends Controller
{
    use AuthorizesRequests;
    use CalculateTime;

    protected $ticketRepository;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function index(Request $request)
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

        $tickets->each(function($ticket) {
            if ($ticket->malfunction) {
                $ticket->wait_time = $this->calculateWaitTime($ticket);
            }
        });

        return view('tickets.index', compact('tickets'));
    }


    public function create()
    {
        $equipments = Equipment::all();
        $equipmentTypes = EquipmentType::cases();

        return view('tickets.create', compact('equipments', 'equipmentTypes'));
    }

    public function store(Request $request)
    {
        // Validar os dados da requisição
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Buscar o equipamento
        $equipment = $this->ticketRepository->findEquipment($validatedData['type'], $validatedData['serial_number']);
        if (!$equipment) {
            return $this->ticketRepository->redirectBackWithError('serial_number',
                'Número de série inválido para este tipo de equipamento.');
        }

        // Criar o registro de malfunção
        $malfunction = $this->ticketRepository->createMalfunction($equipment->id);

        // Criar o ticket
        $ticket = $this->ticketRepository->createTicket($validatedData, $malfunction->id);

        // Tratar a requisição vinda do EquipmentController
        $this->ticketRepository->handleEquipmentControllerRequest($ticket, $equipment->id);

        return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso!');
    }


    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('view', $ticket);

        $ticket->wait_time = $this->calculateWaitTime($ticket);

        return view('tickets.show', compact('ticket'));
    }


    public function edit(Ticket $ticket)
    {
        //Not Implemented
    }

    public function update(Request $request, Ticket $ticket)
    {
        //Not Implemented
    }


    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
