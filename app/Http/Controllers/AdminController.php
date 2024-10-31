<?php
namespace App\Http\Controllers;

use App\Jobs\SendEquipmentRequestRejectedNotification;
use App\Models\Equipment;
use App\Models\EquipmentApprovalRequest;
use App\Models\Admin;
use App\Models\Ticket;
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
    public function requests()
    {
        $typeChangeRequests = TypeChangeRequest::where('status', 'pending')->get();
        $ticketApprovalRequests = EquipmentApprovalRequest::where('status', 'pending')->get();

        return view('admin.requests', compact('typeChangeRequests', 'ticketApprovalRequests'));
    }

    // Método para aprovar uma solicitação
    public function approveTypeChangeRequest(TypeChangeRequest $request)
    {
        $admin = Auth::user(); // Obtém o admin autenticado

        $this->typeChangeRequestRepository->approveRequest($request, $admin->id);

        // Envia o token para o usuário após a aprovação
        $response = $this->typeChangeRequestRepository->sendTypeChangeToken($request->user_id, $request->requested_type);

        return redirect()->back()->with('status', $response['message']);
    }

    public function rejectTypeChangeRequest(TypeChangeRequest $request)
    {
        $admin = Auth::user(); // Obtém o admin autenticado

        $this->typeChangeRequestRepository->rejectRequest($request, $admin->id);

        return redirect()->back()->with('status', 'Solicitação rejeitada.');
    }

    public function approveNewEquipmentRequest(EquipmentApprovalRequest $request)
    {
        $request->update([
            'status' => 'approved',
            'approved_by_admin_id' => auth()->id(), // Salva o ID do admin que aprovou
        ]);

        // Atualiza o status do ticket para 'open'
        $ticket = Ticket::find($request->ticket_id); // Certifique-se de que o ticket_id está presente
        if ($ticket) {
            $ticket->status = 'open';
            $ticket->save();
        }

        return redirect()->route('admin.requests')->with('success', 'Ticket request approved successfully.');
    }

    // Rejeita uma solicitação de ticket
    public function rejectNewEquipmentRequest(EquipmentApprovalRequest $request)
    {
        $equipment = Equipment::find($request->equipment_id);

        // Delete the ticket associated with the request
        $ticket = Ticket::find($request->ticket_id);
        if ($ticket) {
            $ticket->delete(); // Deleta o ticket
        }

        // Deleta o equipamento
        if ($equipment) {
            $equipment->delete(); // Deleta o equipamento
        }

        $request->update([
            'status' => 'rejected',
            'approved_by_admin_id' => auth()->id(), // Salva o ID do admin que rejeitou
        ]);

        // Envia notificação ao usuário
        $user = User::find($request->user_id); // Obtém o usuário que fez a solicitação


        if ($user) {
            // Despacha o job para enviar a notificação

            SendEquipmentRequestRejectedNotification::dispatch($user);
        }

        return redirect()->route('admin.requests')->with('error', 'Ticket request rejected.');
    }


}
