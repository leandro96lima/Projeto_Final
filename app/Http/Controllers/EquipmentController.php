<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Enums\EquipmentType;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();
        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        return view('equipments.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'new_type' => 'nullable|string|max:255', // Novo campo para o tipo
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'room' => 'nullable|string|max:255',
            'serial_number' => 'required|string|max:255|unique:equipments',
        ]);

        // Verifica se o tipo é 'OTHER' e, se sim, usa o novo tipo
        if ($validatedData['type'] === 'OTHER' && !empty($validatedData['new_type'])) {
            $validatedData['type'] = $validatedData['new_type'];

            // Aqui você pode adicionar lógica para atualizar o enum ou banco de dados com o novo tipo, se necessário
        }

        Equipment::create($validatedData);

        return redirect()->route('equipments.index')->with('success', 'Equipamento criado com sucesso!');
    }



    public function show(Equipment $equipment)
    {
        return view('equipments.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        return view('equipments.edit', compact('equipment'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'room' => 'nullable|string|max:255',
            'serial_number' => 'required|string|max:255|unique:equipments,serial_number,' . $equipment->id,
        ]);

        $equipment->update($validatedData);

        return redirect()->route('equipments.index')->with('success', 'Equipamento atualizado com sucesso!');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Equipamento eliminado com sucesso!');
    }
}
