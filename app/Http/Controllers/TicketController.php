<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Technician;
use App\Models\Malfunction;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Carrega os tickets com as relações de técnicos e avarias
        $tickets = Ticket::with(['technician.user', 'malfunction'])->get();
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtém técnicos e avarias para popular os campos do formulário de criação de ticket
        $technicians = Technician::all();
        $malfunctions = Malfunction::all();

        // Retorna a view de criação de ticket
        return view('tickets.create', compact('technicians', 'malfunctions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados do formulário
        $validatedData = $request->validate([
            'malfunction_id' => 'required|exists:malfunctions,id',
            'technician_id' => 'required|exists:technicians,id',
            'status' => 'required|string|max:255',
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
        ]);

        // Criação do ticket
        $ticket = Ticket::create($validatedData);

        // Redireciona para a lista de tickets com uma mensagem de sucesso
        return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        // Exibe os detalhes do ticket selecionado
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        // Obtém técnicos e avarias para o formulário de edição
        $technicians = Technician::all();
        $malfunctions = Malfunction::all();

        // Retorna a view de edição de ticket
        return view('tickets.edit', compact('ticket', 'technicians', 'malfunctions'));
    }

    /**
     * Update the specified resource in storage.
     */
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
