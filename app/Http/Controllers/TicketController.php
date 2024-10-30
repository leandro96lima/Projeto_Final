<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Ticket;
use App\Models\Malfunction;
use App\Traits\CalculateResolutionTime;
use App\Traits\CalculateWaitTime;
use App\Models\Technician;
use App\Models\TicketApprovalRequest;
use Illuminate\Http\Request;
use App\Enums\EquipmentType;

class TicketController extends Controller
{
    use CalculateWaitTime;
    use CalculateResolutionTime;

    public function index()
    {
        $query = Ticket::with(['technician.user', 'malfunction']);

        $tickets = $query->get();

        foreach ($tickets as $ticket) {
            if ($ticket->malfunction) {
                $ticket->wait_time = $this->calculateWaitTime($ticket);
            }
        }
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $equipment = Equipment::where('type', $validatedData['type'])
            ->where('serial_number', $validatedData['serial_number'])
            ->first();

        if (!$equipment) {
            return redirect()->back()->withErrors(['serial_number' => 'Número de série inválido para este tipo de equipamento.'])->withInput();
        }

        $malfunction = new Malfunction();
        $malfunction->equipment_id = $equipment->id;
        $malfunction->save();

        $ticket = new Ticket();
        $ticket->title = $validatedData['title'];
        $ticket->description = $validatedData['description'];
        $ticket->open_date = now();
        $ticket->malfunction_id = $malfunction->id;
        $ticket->wait_time;
        $ticket->save();

        // Verifica se o ticket foi criado via partial e precisa de aprovação
        if (session('ticket_requires_approval', false)) {
            // Cria a solicitação de aprovação
            TicketApprovalRequest::create([
                'ticket_id' => $ticket->id,
                'user_id' => auth()->id(), // Usuário que criou o ticket
                'status' => 'pending',
            ]);

            // Limpa a variável da sessão para evitar que o estado persista acidentalmente
            session()->forget('ticket_requires_approval');

            // Redireciona com uma mensagem de notificação sobre a aprovação pendente
            return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso! Aguarde a aprovação de um administrador.');
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso!');
    }


    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);

        $ticket->wait_time = $this->calculateWaitTime($ticket);

        return view('tickets.show', compact('ticket'));
    }


    public function edit(Ticket $ticket)
    {
        $technicians = Technician::all();
        $malfunctions = Malfunction::all();

        return view('tickets.edit', compact('ticket', 'technicians', 'malfunctions'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validatedData = $request->validate([
            'malfunction_id' => 'required|exists:malfunctions,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'status' => 'nullable|string|in:open,in_progress,closed',
        ]);

        $ticket->update($validatedData + ['wait_time' => $this->calculateWaitTime($ticket)]);

        $ticket->update($validatedData + ['resolution_time' => $this->calculateResolutionTime($ticket)]);

        return redirect()->route('malfunctions.show', $ticket->malfunction_id);
    }


    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
