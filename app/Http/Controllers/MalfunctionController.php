<?php
namespace App\Http\Controllers;

use App\Http\Requests\GetMalfunctionsRequest;
use App\Http\Requests\StoreMalfunctionRequest;
use App\Models\Malfunction;
use App\Services\MalfunctionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MalfunctionController extends Controller
{
    use AuthorizesRequests;

    protected $malfunctionService;

    public function __construct(MalfunctionService $malfunctionService)
    {
        $this->malfunctionService = $malfunctionService;
    }

    public function index(GetMalfunctionsRequest $request)
    {
        $validatedData = $request->validated(); // Validates the request

        // Pass validated data to the service
        $malfunctions = $this->malfunctionService->getMalfunctions($validatedData);

        return view('malfunctions.index', compact('malfunctions'));
    }

    public function show($id)
    {
        $this->authorize('viewAny', Malfunction::class);
        $malfunction = $this->malfunctionService->showMalfunction($id);
        return view('malfunctions.show', compact('malfunction'));
    }


   //NOTA:
   //Todas as avarias são criadas durante o processo de criação do ticket



    public function edit(Malfunction $malfunction, Request $request)
    {
        $this->authorize('viewAny', Malfunction::class);
        $malfunction->load('equipment', 'technician', 'ticket');

        return view('malfunctions.edit', [
            'malfunction' => $malfunction,
            'action' => $request->query('action', ''),
            'equipmentType' => $malfunction->equipment->type,
            'ticketUrgent' => $malfunction->ticket->urgent,
        ]);
    }

    public function update(StoreMalfunctionRequest $request, Malfunction $malfunction)
    {
        $this->authorize('update', $malfunction);
        $this->malfunctionService->updateMalfunction($request, $malfunction);
        return redirect()->route('tickets.show', $malfunction->id);
    }

    public function destroy(Malfunction $malfunction)
    {
        $this->authorize('delete', $malfunction);
        $malfunction->delete();
        return redirect()->route('malfunctions.index')->with('success', 'Avaria removida com sucesso!');
    }
}
