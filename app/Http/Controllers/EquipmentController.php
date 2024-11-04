<?php

namespace App\Http\Controllers;

use App\Jobs\NotifyAdminsOfEquipment;
use App\Models\Equipment;
use App\Models\EquipmentApprovalRequest;
use App\Models\User;
use App\Notifications\EquipmentCreatedNotification;
use Illuminate\Http\Request;
use App\Enums\EquipmentType;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::query();

        // Lógica de busca utilizando o scope
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->search($search);
        }

        // Lógica de ordenação utilizando o scope
        if ($request->filled('sort')) {
            $query->sortBy($request->sort, $request->direction);
        }

        // Paginação
        $equipments = $query->paginate(10);

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
            'serial_number' => 'required|string|max:255',
        ]);

        $validatedData['type'] = in_array($validatedData['type'], ['OTHER', 'NEW']) && !empty($validatedData['new_type'])
            ? $validatedData['new_type']
            : $validatedData['type'];

        $validatedData['type'] = ucwords(strtolower($validatedData['type']));

        // Verificação manual de duplicidade
        if (Equipment::where('type', $validatedData['type'])->where('serial_number', $validatedData['serial_number'])->exists()) {
            return redirect()->back()->withErrors([
                'serial_number' => 'Este número de série já existe para este tipo de equipamento.'
            ])->withInput()->with('from_partial', 'user-create-equipment'); // Adicionando a variável para a partial
        }

        $equipment = Equipment::create($validatedData);


        // Se a rota parcial for 'user-create-equipment', envie a notificação ao admin
        if ($request->input('from_partial') === 'user-create-equipment') {
            // Enviar notificação para todos os admins
            NotifyAdminsOfEquipment::dispatch($equipment);
            $equipment->is_approved = false;
            $equipment->save();

            // Cria a solicitação de aprovação
            EquipmentApprovalRequest::create([
                'equipment_id' => $equipment->id, // Ajuste isso conforme a lógica de como você associa tickets a equipamentos
                'user_id' => auth()->id(), // Usuário que criou o equipamento
                'status' => 'pending',
            ]);

            session()->put('from_equipment_controller', true);


            return view('tickets.create', [
                'other_type' => $equipment->type,
                'other_serial_number' => $equipment->serial_number,
                'other_room' => $equipment->room,
                'equipments' => Equipment::all(),
                'success' => 'Equipamento criado com sucesso!',
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
            'serial_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('equipments')->ignore($equipment->id)->where(function ($query) use ($request) {
                    return $query->where('type', $request->type);
                }),
            ],
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
