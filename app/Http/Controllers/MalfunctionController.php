<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Malfunction;
use App\Models\Technician;
use Illuminate\Http\Request;

class MalfunctionController extends Controller
{
    public function index()
    {
        $malfunctions = Malfunction::with('equipment', 'technician')->get();
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
            'status' => 'required|string|max:255',
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'technician_id' => 'required|exists:technicians,id',
            'equipment_id' => 'required|exists:equipments,id',
            'urgent' => 'required|boolean', // Adicionei a validação para urgent
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

        $ticketUrgent = $malfunction->urgent; // Atualize para usar o urgent do próprio malfunction

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
            'urgent' => 'required|boolean', // Validação para urgent
        ]);

        // Atualiza o status e solução apenas se a ação for fechar
        if ($request->input('action') != 'abrir') {
            $malfunction->update([
                'status' => $validatedData['status'],
                'solution' => $validatedData['solution'],
                'cost' => $validatedData['cost'],
            ]);
        } else {
            $malfunction->update([
                'status' => $validatedData['status'],
                'diagnosis' => $validatedData['diagnosis'],
                'urgent' => $validatedData['urgent'],
            ]);
        }


        return redirect()->route('malfunctions.show', $malfunction->id);
    }

    public function destroy(Malfunction $malfunction)
    {
        $malfunction->delete();

        return redirect()->route('malfunctions.index')->with('success', 'Avaria removida com sucesso!');
    }
}
