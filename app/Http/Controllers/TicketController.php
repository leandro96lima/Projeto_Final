<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
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
        // Validação dos dados de entrada
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Verificar se o equipamento já existe ou criar um novo
        $equipment = Equipment::firstOrCreate([
            'type' => $validatedData['type'],
        ]);

        // Criação de um novo Malfunction (não inclui 'urgent', pois ele pertence a Ticket)
        $malfunction = new Malfunction();
        $malfunction->status = 'open'; // Definindo o status como 'open'
        $malfunction->equipment_id = $equipment->id;  // Associando o equipamento
        $malfunction->save();  // Salvando o Malfunction

        // Criação do Ticket e associação ao Malfunction
        $ticket = new Ticket();
        $ticket->title = $validatedData['title'];
        $ticket->description = $validatedData['description'];
        $ticket->open_date = now();

        // Atribuímos o malfunction_id ao ticket
        $ticket->malfunction_id = $malfunction->id;

        // Salvando o ticket
        $ticket->save();

        // Redirecionando ou retornando uma resposta adequada
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
