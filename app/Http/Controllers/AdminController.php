<?php

namespace App\Http\Controllers;

use App\Mail\TokenMail;
use App\Models\Admin;
use App\Models\TypeChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        // Busca o usuário pelo ID e envia o token
        $user = User::find($request->user_id);
        $this->sendTypeChangeToken($request->user_id);

        return redirect()->back()->with('status', 'Solicitação aprovada.');
    }

    // Método para rejeitar uma solicitação
    public function rejectTypeChangeRequest(TypeChangeRequest $request)
    {
        $request->update(['status' => 'rejected']);
        return redirect()->back()->with('status', 'Solicitação rejeitada.');
    }

    public function sendTypeChangeToken(Int $user_id)
    {


        // Valida se o usuário já enviou uma solicitação de token recentemente, para evitar spam
        if (session()->has('type_change_token_sent_at') && now()->diffInMinutes(session('type_change_token_sent_at')) < 5) {
            return back()->with('status', 'You must wait before requesting a new token.');
        }

        // Gera um token aleatório
        $token = Str::random(6);

        $user = User::find($user_id);
        // Envia o e-mail de forma assíncrona
        Mail::to($user->email)->later(now()->addSeconds(10), new TokenMail($token));

        // Armazena o token na sessão e o timestamp de envio
        session(['type_change_token' => $token]);
        session(['type_change_token_sent_at' => now()]);

        // Redireciona de volta com uma mensagem de sucesso
        return back()->with('status', 'Token sent to User email.');
    }

}
