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

    public function getMalfunctions($request)
    {

        // Build the query for malfunctions, excluding those with tickets in 'pending_approval'
        $malfunctionsQuery = $this->malfunctionRepository->getMalfunctionsFromDb(
            $request->input('status'),
            $request->input('search'),
            $request->input('sort'),
            $request->input('direction')
        );

        // Paginate the results
        $paginatedMalfunctions = $malfunctionsQuery->simplePaginate(20);

        // Process resolution time for each malfunction
        $paginatedMalfunctions->each(function ($malfunction) {
            $this->calculateResolutionTime($malfunction->ticket);
        });

        return $paginatedMalfunctions; // Ensure you return the paginated instance
    }

    public function showMalfunction($id)
    {
        $malfunction = $this->malfunctionRepository->findMalfunction($id);
        $this->calculateResolutionTime($malfunction->ticket);

        return $malfunction;
    }

    public function updateMalfunction(StoreMalfunctionRequest $request, Malfunction $malfunction)
    {
        $validatedData = $request->validated();
        $ticket = $malfunction->ticket;

        if ($ticket) {
            $this->ticketRepository->updateTicketStatus($ticket, $validatedData);
        }

        $this->malfunctionRepository->updateMalfunctionDetails($malfunction, $validatedData);

        return $malfunction;
    }



}
