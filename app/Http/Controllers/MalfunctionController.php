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
        // Obtenha todos os equipamentos e técnicos para preencher os selects
        $equipments = Equipment::all(); // ou qualquer outra lógica que você tenha
        $technicians = Technician::all(); // ou qualquer outra lógica que você tenha

        return view('malfunctions.create', compact('equipments', 'technicians'));
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
            'cost' => 'nullable|numeric',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'solution' => 'nullable|string',
            'technician_id' => 'required|exists:technicians,id',
            'equipment_id' => 'required|exists:equipments,id',
            'urgent' => 'required|boolean',
        ]);

        // Criação da nova avaria (malfunction)
        Malfunction::create($validatedData);

        // Redireciona para a página de listagem com uma mensagem de sucesso
        return redirect()->route('tickets.index')->with('success', 'Avaria criada com sucesso!');
    }

    public function show(Malfunction $malfunction)
    {
        $malfunction->load('technician.user'); // Carregue a relação de técnico diretamente
        return view('malfunctions.show', compact('malfunction'));
    }

    public function edit(Malfunction $malfunction, Request $request)
    {
        $malfunction->load('equipment', 'technician'); // Carrega as relações necessárias
        $action = $request->query('action', '');
        return view('malfunctions.edit', compact('malfunction', 'action'));
    }

    public function update(Request $request, Malfunction $malfunction)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|max:255',
            'cost' => 'nullable|numeric',
            'solution' => 'nullable|string',
            'resolution_time' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'urgent' => 'required|boolean',
        ]);

        // Verifique qual ação está sendo executada
        if ($request->input('action') == 'fechar') {
            // Se for para "fechar", atualize também os campos de solução e custo
            $malfunction->update([
                'status' => $validatedData['status'],
                'solution' => $validatedData['solution'],
                'cost' => $validatedData['cost'],
            ]);
        } else {
            // Se for para "abrir", atualize apenas o status e diagnóstico
            $malfunction->update([
                'status' => $validatedData['status'],
                'diagnosis' => $validatedData['diagnosis'],
                'urgent' => $validatedData['urgent'],
            ]);
        }

        // Redireciona para a visualização da avaria atualizada
        return redirect()->route('malfunctions.show', $malfunction->id)->with('success', 'Avaria atualizada com sucesso!');
    }

    public function destroy(Malfunction $malfunction)
    {
        // Deleta a avaria selecionada
        $malfunction->delete();

        // Redireciona para a lista de avarias com uma mensagem de sucesso
        return redirect()->route('malfunctions.index')->with('success', 'Avaria removida com sucesso!');
    }
}
