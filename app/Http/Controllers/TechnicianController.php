<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $technicians = Technician::with('user')->get();
        return view('technicians.index', compact('technicians'));
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
    public function show(Technician $tecnico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technician $tecnico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technician $tecnico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technician $tecnico)
    {
        //
    }
}
