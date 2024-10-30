<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Equipment;
use App\Models\Malfunction;
use App\Models\Technician;
use Illuminate\Http\Request;

class MalfunctionController extends Controller
{
    public function index()
    {
        $malfunctions = Malfunction::with('equipment', 'technician', 'ticket')->get();

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
        $malfunction->load('technician.user');
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

        // Obtenha o ticket associado ao malfunction
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
            $ticket->progress_date = now();
            $ticket->save();

            $ticket->wait_time = $this->calculateWaitTime($ticket);
        }

        return redirect()->route('malfunctions.show', $malfunction->id);
    }

    public function destroy(Malfunction $malfunction)
    {
        $malfunction->delete();

        return redirect()->route('malfunctions.index')->with('success', 'Avaria removida com sucesso!');
    }

    private function calculateWaitTime($ticket)
    {
        // Verifica se o ticket tem um malfunction associado
        if ($ticket) {
            // Se o ticket estiver aberto
            if ($ticket->status == 'open') {
                // Converte open_date para um objeto Carbon e calcula a diferença em minutos
                return \Carbon\Carbon::parse($ticket->open_date)->diffInMinutes(now());
            }

            // Se o ticket estiver em progresso
            if ($ticket->status == 'in_progress' && $ticket->progress_date) {
                // Converte open_date e progress_date para objetos Carbon e calcula a diferença em minutos
                return \Carbon\Carbon::parse($ticket->progress_date)->diffInMinutes($ticket->open_date);
            }
        }

        return null; // Retorna null se o ticket não estiver aberto ou em progresso
    }

}
