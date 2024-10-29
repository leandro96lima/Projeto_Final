<?php

namespace App\Http\Controllers;

use App\Mail\TokenMail;
use App\Models\Admin;
use App\Models\TypeChangeRequest;
use App\Models\User;
use App\Repositories\TypeChangeRequestRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    protected TypeChangeRequestRepository $typeChangeRequestRepository;

    public function __construct(TypeChangeRequestRepository $typeChangeRequestRepository)
    {
        $this->typeChangeRequestRepository = $typeChangeRequestRepository;
    }


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
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        Admin::create($validatedData);

        return redirect()->route('admins.index')->with('success', 'Admin criado com sucesso!');
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
    public function approveTypeChangeRequest(TypeChangeRequest $request, TypeChangeRequestRepository $repository)
    {
        $admin = Auth::user(); // Obtém o admin autenticado

        $repository->approveRequest($request, $admin->id);

        // Envia o token para o usuário após a aprovação
        $this->sendTypeChangeToken($request->user_id, $request->requested_type);

        return redirect()->back()->with('status', 'Solicitação aprovada.');
    }

    public function rejectTypeChangeRequest(TypeChangeRequest $request, TypeChangeRequestRepository $repository)
    {
        $admin = Auth::user(); // Obtém o admin autenticado

        $repository->rejectRequest($request, $admin->id);

        return redirect()->back()->with('status', 'Solicitação rejeitada.');
    }

    public function sendTypeChangeToken(int $user_id, string $requestedType = null)
    {
        if (session()->has('type_change_token_sent_at') && now()->diffInMinutes(session('type_change_token_sent_at')) < 5) {
            return back()->with('status', 'Você deve esperar antes de solicitar um novo token.');
        }

        $token = Str::random(6);
        $user = User::find($user_id);
        $recipientEmail = ($requestedType === 'Admin' && User::where('type', 'Admin')->count() === 0)
            ? 'helpdesk@example.com'
            : $user->email;

        Mail::to($recipientEmail)->later(now()->addSeconds(10), new TokenMail($token));
        session(['type_change_token' => $token, 'type_change_token_sent_at' => now()]);

        return back()->with('status', 'Token enviado para ' . ($recipientEmail === 'helpdesk@example.com' ? 'o e-mail do helpdesk.' : 'o e-mail do usuário.'));
    }

}
