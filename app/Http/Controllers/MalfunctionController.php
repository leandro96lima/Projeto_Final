<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Malfunction;
use Illuminate\Http\Request;

class MalfunctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $malfunctions = Malfunction::with('equipment')->get(); // Executa a consulta e obtém os dados
        return view('malfunctions.index', compact('malfunctions'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Malfunction $avaria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Malfunction $avaria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Malfunction $avaria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Malfunction $avaria)
    {
        //
    }
}
