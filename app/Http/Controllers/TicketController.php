<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentApprovalRequest;
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

    public function index(Request $request)
    {
        $query = Ticket::with(['technician.user', 'malfunction']);

        // Verifica se há um status a ser filtrado
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Verifica se há uma pesquisa a ser realizada
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                // Adicione as condições que você deseja pesquisar
                $q->whereHas('malfunction', function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhereHas('equipment', function($q) use ($search) {
                            $q->where('type', 'like', '%' . $search . '%');
                        });
                });
            });
        }

        $tickets = $query->paginate(10);

        foreach ($tickets as $ticket) {
            if ($ticket->malfunction) {
                $ticket->wait_time = $this->calculateWaitTime($ticket);
                $ticket->resolution_time = $this->calculateResolutionTime($ticket);
                $ticket->save();
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

        // Verifica se a requisição veio do EquipmentController
        $comesFromEquipmentController = session('from_equipment_controller', false);

        // Define o status como 'pending_approval' ou 'open'
        $ticket->status = $comesFromEquipmentController ? 'pending_approval' : '    open';
        $ticket->wait_time = null; // Ou ajuste conforme necessário
        $ticket->save(); // Salva o ticket

        if ($comesFromEquipmentController) {
            // Aqui, associar o ticket_id à EquipmentApprovalRequest
            $equipmentApprovalRequest = EquipmentApprovalRequest::where('equipment_id', $equipment->id)
                ->where('status', 'pending') // Certifique-se de pegar a solicitação correta
                ->first();

            if ($equipmentApprovalRequest) {
                $equipmentApprovalRequest->ticket_id = $ticket->id; // Atribui o ID do ticket
                $equipmentApprovalRequest->save(); // Salva a alteração
            }

            session()->forget('from_equipment_controller'); // Limpa a sessão
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

        // Atualiza o `progress_date` quando o status muda para "in_progress"
        if ($validatedData['status'] === 'in_progress' && !$ticket->progress_date) {
            $ticket->progress_date = now();
        }

        // Define `close_date` e `resolution_time` ao mudar para "closed"
        if ($validatedData['status'] === 'closed' && !$ticket->close_date) {
            $ticket->close_date = now();
            $ticket->resolution_time = $this->calculateResolutionTime($ticket);
            $ticket->save();
        } elseif ($validatedData['status'] !== 'closed') {
            // Atualiza o tempo de resolução em andamento
            $ticket->resolution_time = $this->calculateResolutionTime($ticket);
            $ticket->save();
        }

        // Atualiza outros campos do ticket e salva
        $ticket->update($validatedData + [
                'wait_time' => $this->calculateWaitTime($ticket),
                'resolution_time' => $this->calculateResolutionTime($ticket),
            ]);

        return redirect()->route('malfunctions.show', $ticket->malfunction_id);
    }


    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
