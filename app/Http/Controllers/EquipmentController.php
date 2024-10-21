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
        // Return a view to create a new equipment (if using Blade)
        return view('equipments.create'); // Adjust the path to your view
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
            'room' => 'required|string|max:255',
        ]);

        // Create a new equipment record
        $equipment = Equipment::create($validatedData);

        return response()->json($equipment, 201); // Respond with the created equipment
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipamento)
    {
        // Return a single equipment record
        return response()->json($equipamento);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipamento)
    {
        // Return a view to edit the equipment (if using Blade)
        return view('equipments.edit', compact('equipamento')); // Adjust the path to your view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipamento)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'room' => 'required|string|max:255',
        ]);

        // Update the equipment record
        $equipamento->update($validatedData);

        return response()->json($equipamento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipamento)
    {
        // Delete the equipment record
        $equipamento->delete();

        return response()->json(null, 204); // Respond with no content
    }
}
