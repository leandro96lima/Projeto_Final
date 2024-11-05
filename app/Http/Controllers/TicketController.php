<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Equipment;
use App\Models\Ticket;
use App\Services\TicketService;
use App\Traits\CalculateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Enums\EquipmentType;

class TicketController extends Controller
{
    use AuthorizesRequests;

    protected $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }


    public function index(Request $request)
    {
        // Use o TicketService para obter os tickets
        $tickets = $this->ticketService->getTickets($request);

        return view('tickets.index', compact('tickets'));
    }


    public function create()
    {
        $equipments = Equipment::all();
        $equipmentTypes = EquipmentType::cases();

        return view('tickets.create', compact('equipments', 'equipmentTypes'));
    }

    public function store(StoreTicketRequest $request)
    {
        $validatedData = $request->validated();

        try {
            // Use o TicketService para criar o ticket
           $this->ticketService->createTicket($validatedData);

            return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['ticket' => $e->getMessage()])->withInput($validatedData);
        }
    }

    public function show($id)
    {
        $ticket = $this->ticketService->showTicket($id);
        $this->authorize('view', $ticket);

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

        // Verifica se o ticket tem uma malfuncion associada
        if ($ticket->malfunction) {
            // Elimina a malfuncion associada
            $ticket->malfunction->delete();
        }

        // Elimina o ticket
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket e malfuncion eliminados com sucesso.');
    }

}
