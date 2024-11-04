<?php
namespace App\Services;

use App\Models\Malfunction;
use App\Http\Requests\StoreMalfunctionRequest;

use App\Repositories\MalfunctionRepository;
use App\Repositories\TicketRepository;
use App\Traits\CalculateTime;
use Illuminate\Http\Request;


class MalfunctionService
{

    use CalculateTime;

    protected $malfunctionRepository;
    protected $ticketRepository;

    public function __construct(MalfunctionRepository $malfunctionRepository, TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->malfunctionRepository = $malfunctionRepository;
    }

    public function getMalfunctions(array $validatedData)
    {
        // Extract the search term from the validated data
        $search = $validatedData['search'] ?? null;

        // Build the query for malfunctions, excluding those with tickets in 'pending_approval'
        $malfunctionsQuery = $this->malfunctionRepository->getMalfunctions($search)
            ->whereDoesntHave('ticket', function ($query) {
                $query->where('status', 'pending_approval');
            });

        // Paginate the results
        $paginatedMalfunctions = $malfunctionsQuery->paginate(10);

        // Process resolution time for each malfunction
        $paginatedMalfunctions->each(function ($malfunction) {
            $malfunction->ticket->resolution_time = $this->calculateResolutionTime($malfunction->ticket);
        });

        return $paginatedMalfunctions; // Ensure you return the paginated instance
    }

    public function showMalfunction($id)
    {
        $malfunction = $this->malfunctionRepository->findMalfunction($id);
        $malfunction->ticket->resolution_time = $this->calculateResolutionTime($malfunction->ticket);

        return $malfunction;
    }

    public function updateMalfunction(StoreMalfunctionRequest $request, Malfunction $malfunction)
    {
        $validatedData = $request->validated();
        $ticket = $malfunction->ticket;

        if ($ticket) {
            $this->ticketRepository->updateTicketStatus($ticket, $validatedData);
        }

        $this->updateMalfunctionDetails($malfunction, $validatedData);

        return $malfunction;
    }


    private function updateMalfunctionDetails(Malfunction $malfunction, array $validatedData)
    {
        if ($validatedData['status'] === 'in_progress') {
            $malfunction->update(['diagnosis' => $validatedData['diagnosis']]);
        } elseif ($validatedData['status'] === 'closed') {
            $malfunction->update([
                'solution' => $validatedData['solution'],
                'cost' => $validatedData['cost']
            ]);
        }
    }
}
