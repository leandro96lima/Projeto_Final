<?php

namespace App\Http\Controllers;

use App\Models\Malfunction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\CalculateTime;
use Illuminate\Http\Request;

class MalfunctionController extends Controller
{
    use AuthorizesRequests;
    use CalculateTime;

    public function index(Request $request)
    {

        $query = Malfunction::with('equipment', 'technician', 'ticket');

        // Filtra por pesquisa
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        $malfunctions = $query->paginate(10);

        // Atualiza o resolution_time
        foreach ($malfunctions as $malfunction) {
            $malfunction->ticket->resolution_time = $this->calculateResolutionTime($malfunction->ticket);
        }

        return view('malfunctions.index', compact('malfunctions'));
    }



    public function create()
    {
        //Not Implemented
    }

    public function show(Malfunction $malfunction)
    {
        // Carregar relações necessárias
        $malfunction->load('equipment', 'technician.user', 'ticket');
        $malfunction->ticket->resolution_time = $this->calculateResolutionTime($malfunction->ticket);


        return view('malfunctions.show', compact('malfunction'));
    }


    public function edit(Malfunction $malfunction, Request $request)
    {
        $this->authorize('viewAny', Malfunction::class);

        // Carrega as relações necessárias
        $malfunction->load('equipment', 'technician', 'ticket');

        return view('malfunctions.edit', [
            'malfunction' => $malfunction,
            'action' => $request->query('action', ''),
            'equipmentType' => $malfunction->equipment->type, // Acesso direto ao atributo
            'ticketUrgent' => $malfunction->ticket->urgent,
        ]);
    }

    public function update(Request $request, Malfunction $malfunction)
    {
        $this->authorize('update', $malfunction);

        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
            'cost' => 'nullable|numeric',
            'solution' => 'nullable|string',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'urgent' => 'required|boolean',
        ]);

        $ticket = $malfunction->ticket;

        // Atualiza o ticket com os dados de status e urgência
        if ($ticket) {
            $ticket->update([
                'status' => $validatedData['status'],
                'urgent' => $validatedData['urgent']
            ]);
        }

        // Verifica a ação e atualiza os dados da malfunction
        if ($request->input('action') === 'abrir') {
            $malfunction->update(['diagnosis' => $validatedData['diagnosis']]);
        } else {
            $malfunction->update([
                'solution' => $validatedData['solution'],
                'cost' => $validatedData['cost'],
            ]);
        }

        return redirect()->route('malfunctions.show', $malfunction->id);
    }

    public function destroy(Malfunction $malfunction)
    {
        $this->authorize('delete');

        $malfunction->delete();

        return redirect()->route('malfunctions.index')->with('success', 'Avaria removida com sucesso!');
    }
}
