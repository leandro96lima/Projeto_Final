<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\TypeChangeRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }

    // Método para listar as solicitações pendentes
    public function typeChangeRequests()
    {
        $requests = TypeChangeRequest::where('status', 'pending')->get();
        return view('admin.type-change-requests', compact('requests'));
    }

    // Método para aprovar uma solicitação
    public function approveTypeChangeRequest(TypeChangeRequest $request)
    {
        $request->update(['status' => 'approved']);

        // Atualizar o tipo de usuário
        $user = $request->user;
        $user->update(['type' => $request->requested_type]);

        return redirect()->back()->with('status', 'Solicitação aprovada e tipo de usuário atualizado.');
    }

    // Método para rejeitar uma solicitação
    public function rejectTypeChangeRequest(TypeChangeRequest $request)
    {
        $request->update(['status' => 'rejected']);
        return redirect()->back()->with('status', 'Solicitação rejeitada.');
    }


}
