<?php

namespace App\Http\Controllers;

    use App\Models\Equipment;
    use App\Models\Malfunction;
    use App\Models\Technician;
    use Illuminate\Http\Request;

class MalfunctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $malfunctions = Malfunction::with('equipment', 'technician.user')->get(); // Certifique-se de incluir a relação technician
        return view('malfunctions.index', compact('malfunctions'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Lógica para criar uma nova avaria
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'equipment_id' => 'required|exists:equipments,id',
            'technician_id' => 'required|exists:technicians,id', // Validação para garantir que technician_id existe
        ]);

        $malfunction = Malfunction::create($validatedData);

        return redirect()->route('malfunctions.index')->with('success', 'Avaria criada com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Malfunction $malfunction)
    {
        $malfunction->load('technician.user'); // Carregue a relação de técnico diretamente
        return view('malfunctions.show', compact('malfunction'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Malfunction $malfunction)
    {
        $malfunction->load('tickets.technician.user');
        return view('malfunctions.edit', compact('malfunction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Malfunction $malfunction)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'technician_id' => 'required|exists:technicians,id', // Inclua esta validação
        ]);

        $malfunction->update($validatedData);

        return redirect()->route('malfunctions.index')->with('success', 'Avaria atualizada com sucesso!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Malfunction $malfunction)
    {
        // Deleta a avaria selecionada
        $malfunction->delete();

        // Redireciona para a lista de avarias com uma mensagem de sucesso
        return redirect()->route('malfunctions.index')->with('success', 'Avaria removida com sucesso!');
    }

}
