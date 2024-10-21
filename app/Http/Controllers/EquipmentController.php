<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all equipment records
        $equipments = Equipment::all();
        return view('equipments.index', compact('equipments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a view to create a new equipment
        return view('equipments.create'); // Ajuste o caminho para a sua view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'room' => 'nullable|string|max:255',
        ]);

        // Create a new equipment record
        Equipment::create($validatedData);

        // Redirect to the index with a success message
        return redirect()->route('equipments.index')->with('success', 'Equipamento criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        // Return a single equipment record
        return view('equipments.show', compact('equipment')); // Ajuste o caminho para a sua view
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        // Return a view to edit the equipment
        return view('equipments.edit', compact('equipment')); // Ajuste o caminho para a sua view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'room' => 'nullable|string|max:255',
        ]);

        // Update the equipment record
        $equipment->update($validatedData);

        // Redirect to the index with a success message
        return redirect()->route('equipments.index')->with('success', 'Equipamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        // Delete the equipment record
        $equipment->delete();

        // Redirect to the index with a success message
        return redirect()->route('equipments.index')->with('success', 'Equipamento eliminado com sucesso!');
    }
}
