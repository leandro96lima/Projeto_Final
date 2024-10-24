<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Technician;
use App\Models\Malfunction;
use Illuminate\Http\Request;

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
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'urgent' => 'boolean',
        ]);

        // Criação do novo ticket
        $ticket = Ticket::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'urgent' => $validatedData['urgent'] ?? false,
            'open_date' => now(),
        ]);

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
        $validatedData = $request->validate([
            'malfunction_id' => 'required|exists:malfunctions,id',
            'technician_id' => 'required|exists:technicians,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
        ]);

        $ticket->update($validatedData);

        return redirect()->route('malfunctions.show');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket removido com sucesso!');
    }
}
