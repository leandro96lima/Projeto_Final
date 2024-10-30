<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Ticket;
use App\Models\Technician;
use App\Models\Malfunction;
use App\Models\TicketApprovalRequest;
use Illuminate\Http\Request;
use App\Enums\EquipmentType;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with(['technician.user', 'malfunction']);

        if ($request->has('status') && $request->status != '') {
            $query->whereHas('malfunction', function ($query) use ($request) {
                $query->where('status', $request->status);
            });
        }

        $tickets = $query->get();
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

        // Verifica se o equipamento existe e é válido
        $equipment = Equipment::where('type', $validatedData['type'])
            ->where('serial_number', $validatedData['serial_number'])
            ->first();

        if (!$equipment) {
            return redirect()->back()->withErrors(['serial_number' => 'Número de série inválido para este tipo de equipamento.'])->withInput();
        }

        // Cria o registro de malfuncionamento
        $malfunction = new Malfunction();
        $malfunction->status = 'open';
        $malfunction->equipment_id = $equipment->id;
        $malfunction->save();

        // Cria o ticket
        $ticket = new Ticket();
        $ticket->title = $validatedData['title'];
        $ticket->description = $validatedData['description'];
        $ticket->open_date = now();
        $ticket->malfunction_id = $malfunction->id;
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



    public function show(Ticket $ticket)
    {
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
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'malfunction_id' => 'required|exists:malfunctions,id',
            'technician_id' => 'required|exists:technicians,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'status' => 'nullable|string|in:open,in_progress,closed',
        ]);

        // Atualizando os dados do ticket
        $ticket->update($validatedData);

        // Atualizando a malfunction associada
        $malfunction = Malfunction::find($validatedData['malfunction_id']);

        // Verifica se existe status a ser atualizado
        if (isset($validatedData['status'])) {
            $malfunction->status = $validatedData['status'];
        }

        // Outros campos de malfunção
        if (isset($validatedData['cost'])) {
            $malfunction->cost = $validatedData['cost'];
        }
        if (isset($validatedData['resolution_time'])) {
            $malfunction->resolution_time = $validatedData['resolution_time'];
        }
        if (isset($validatedData['diagnosis'])) {
            $malfunction->diagnosis = $validatedData['diagnosis'];
        }
        if (isset($validatedData['solution'])) {
            $malfunction->solution = $validatedData['solution'];
        }

        // Atualiza a malfunção
        $malfunction->save();

        return redirect()->route('malfunctions.show', $malfunction->id);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
