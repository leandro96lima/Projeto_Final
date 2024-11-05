<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentRequest;
use App\Models\Equipment;
use App\Services\EquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    protected $equipmentService;

    public function __construct(EquipmentService $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

    public function index(Request $request)
    {
        $query = Equipment::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->search($search);
        }

        if ($request->filled('sort')) {
            $query->sortBy($request->sort, $request->direction);
        }

        $equipments = $query->paginate(10);

        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        return view('equipments.create');
    }

    public function store(StoreEquipmentRequest $request)
    {
        $validatedData = $request->validated();

        $creationResult = $this->equipmentService->createEquipment($validatedData);

        if (isset($creationResult['error'])) {
            return redirect()->back()->withErrors(['serial_number' => $creationResult['error']])
                ->withInput()->with('from_partial', 'user-create-equipment');
        }

        $equipment = $creationResult;

        if ($request->input('from_partial') === 'user-create-equipment') {
            $this->equipmentService->handleApproval($request, $equipment);

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

    public function update(StoreEquipmentRequest $request, Equipment $equipment)
    {
        $validatedData = $request->validated();

        $equipment->update($validatedData);

        return redirect()->route('equipments.index')->with('success', 'Equipamento atualizado com sucesso!');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Equipamento eliminado com sucesso!');
    }
}
