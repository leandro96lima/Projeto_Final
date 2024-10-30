<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyAdminsOfEquipment;
use App\Models\Equipment;
use App\Models\User;
use App\Notifications\EquipmentCreatedNotification;
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
            'new_type' => 'nullable|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'room' => 'nullable|string|max:255',
            'serial_number' => 'required|string|max:255|unique:equipments',
        ]);

        if (in_array($validatedData['type'], ['OTHER', 'NEW']) && !empty($validatedData['new_type'])) {
            $validatedData['type'] = $validatedData['new_type'];
        }

        $equipment = Equipment::create(array_merge($validatedData));

        // Se a rota parcial for 'user-create-equipment', envie a notificação ao admin
        if ($request->input('from_partial') === 'user-create-equipment') {
            // Enviar notificação para todos os admins
            NotifyAdminsOfEquipment::dispatch($equipment);

            return view('tickets.create', [
                'other_type' => $equipment->type,
                'other_serial_number' => $equipment->serial_number,
                'other_room' => $equipment->room,
                'equipments' => Equipment::all(),
                'success' => 'Equipamento criado com sucesso!'
            ]);
        }

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
