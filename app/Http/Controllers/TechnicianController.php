<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    public function index(Request $request)
    {
        $query = Technician::with(['user', 'tickets']); // Carregando tickets para contagem

        // Verifica se há uma pesquisa a ser realizada
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->search($search);
        }

        // Lógica de ordenação utilizando o scope
        if ($request->filled('sort')) {
            $sortField = $request->sort;
            $sortDirection = $request->direction === 'desc' ? 'desc' : 'asc';
            $query->sortBy($sortField, $sortDirection);
        }

        $technicians = $query->withCount('tickets')->paginate(10); // Inclui contagem de tickets

        return view('technicians.index', compact('technicians'));
    }



    public function create()
    {
        return view('technicians.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'specialty' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        Technician::create($validatedData);

        return redirect()->route('technicians.index')->with('success', 'Técnico criado com sucesso!');
    }

    public function show(Technician $technician)
    {
        return view('technicians.show', compact('technician'));
    }

    public function edit(Technician $technician)
    {
        return view('technicians.edit', compact('technician'));
    }

    public function update(Request $request, Technician $technician)
    {

//        $validatedData = $request->validate([
//            'specialty' => 'required|string|in:Electrical,Mechanical,Software',
//            'user_id' => 'required|exists:users,id',
//        ]);
        // dd($validatedData($request->all()));
        //$technician->update($validatedData);
        Technician::findOrFail($technician->id)->update($request->all());
        return redirect()->route('technicians.index')->with('success', 'Técnico atualizado com sucesso!');
    }

    public function destroy(Technician $technician)
    {
        $technician->delete();
        return redirect()->route('technicians.index')->with('success', 'Técnico removido com sucesso!');
    }
}
