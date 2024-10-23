<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Technician;
use App\Models\Malfunction;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['technician.user', 'malfunction'])->get();
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
        // Exibe os detalhes do ticket selecionado
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        // Obtém técnicos e avarias para o formulário de edição
        $technicians = Technician::all();
        $malfunctions = Malfunction::all();

        // Retorna a view de edição de ticket
        return view('tickets.edit', compact('ticket', 'technicians', 'malfunctions'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Validação dos dados do formulário
        $validatedData = $request->validate([
            'malfunction_id' => 'required|exists:malfunctions,id',
            'technician_id' => 'required|exists:technicians,id',
            'title' => 'required|string|max:255', // Se você tem um título para o ticket
            'description' => 'required|string', // Se você tem uma descrição
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
        ]);

        // Atualiza o ticket com os novos dados
        $ticket->update($validatedData);

        // Redireciona para a lista de tickets com uma mensagem de sucesso
        return redirect()->route('malfunctions.show');
    }

    public function destroy(Ticket $ticket)
    {
        // Deleta o ticket selecionado
        $ticket->delete();

        // Redireciona para a lista de tickets com uma mensagem de sucesso
        return redirect()->route('tickets.index')->with('success', 'Ticket removido com sucesso!');
    }
}
