<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Equipment;
use App\Models\Malfunction;
use App\Models\Technician;
use App\Traits\CalculateResolutionTime;
use Illuminate\Http\Request;
use App\Traits\CalculateWaitTime;

class MalfunctionController extends Controller
{
    use CalculateWaitTime;
    use CalculateResolutionTime;

    public function index(Request $request)
    {
        $query = Malfunction::with('equipment', 'technician', 'ticket');

        // Verifica se há uma pesquisa a ser realizada
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('equipment', function($q) use ($search) {
                $q->where('type', 'like', '%' . $search . '%');
            })->orWhereHas('technician.user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhere('diagnosis', 'like', '%' . $search . '%');
        }

        $malfunctions = $query->get();

        // Atualiza o resolution_time para malfunctions com ticket status 'in_progress'
        foreach ($malfunctions as $malfunction) {
            if ($malfunction->ticket && $malfunction->ticket->status === 'in_progress') {
                $malfunction->ticket->resolution_time = $this->calculateResolutionTime($malfunction->ticket);
                $malfunction->ticket->save();
            }
        }

        return view('malfunctions.index', compact('malfunctions'));
    }



    public function create()
    {
        $equipments = Equipment::all();
        $technicians = Technician::all();

        return view('malfunctions.create', compact('equipments', 'technicians'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'technician_id' => 'required|exists:technicians,id',
            'equipment_id' => 'required|exists:equipments,id',
            'urgent' => 'required|boolean',
        ]);

        Malfunction::create($validatedData);

        return redirect()->route('tickets.index')->with('success', 'Avaria criada com sucesso!');
    }

    public function show(Malfunction $malfunction)
    {
        // Carregar relações necessárias
        $malfunction->load('equipment', 'technician.user', 'ticket');

        // Verificar e calcular o tempo de resolução se o status estiver 'in_progress'
        if ($malfunction->ticket && $malfunction->ticket->status === 'in_progress') {
            $malfunction->ticket->resolution_time = $this->calculateResolutionTime($malfunction->ticket);
            $malfunction->ticket->save();
        }

        return view('malfunctions.show', compact('malfunction'));
    }


    public function edit(Malfunction $malfunction, Request $request)
    {
        $malfunction->load('equipment', 'technician', 'ticket');

        $equipmentType = $malfunction->equipment->type;

        $ticketUrgent = $malfunction->ticket->urgent;

        $action = $request->query('action', '');

        return view('malfunctions.edit', compact('malfunction', 'action', 'equipmentType', 'ticketUrgent'));
    }

    public function update(Request $request, Malfunction $malfunction)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
            'cost' => 'nullable|numeric',
            'solution' => 'nullable|string',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'urgent' => 'required|boolean',
        ]);

        $ticket = $malfunction->ticket;

        if ($request->input('action') != 'abrir') {
            $malfunction->update([
                'solution' => $validatedData['solution'],
                'cost' => $validatedData['cost'],
            ]);

            if ($ticket) {
                $ticket->update([
                    'status' => $validatedData['status'],
                    'urgent' => $validatedData['urgent']
                ]);
            }
        } else {
            $malfunction->update([
                'diagnosis' => $validatedData['diagnosis'],
            ]);

            if ($ticket) {
                $ticket->update([
                    'status' => $validatedData['status'],
                    'urgent' => $validatedData['urgent']
                ]);
            }
        }

        if ($ticket && $ticket->status == 'in_progress') {
            $ticket->progress_date = $ticket->progress_date ?? now();
            $ticket->resolution_time = $this->calculateResolutionTime($ticket);
            $ticket->save();
        }

        if ($ticket && $ticket->status == 'closed') {
            $ticket->resolution_time = $this->calculateResolutionTime($ticket);
            $ticket->save();
        }

        return redirect()->route('malfunctions.show', $malfunction->id);
    }

    public function destroy(Malfunction $malfunction)
    {
        $malfunction->delete();

        return redirect()->route('malfunctions.index')->with('success', 'Avaria removida com sucesso!');
    }
}
