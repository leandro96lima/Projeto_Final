<?php
namespace App\Repositories;

use App\Models\Malfunction;

class MalfunctionRepository
{
    protected $malfunction;

    public function __construct(Malfunction $malfunction)
    {
        $this->malfunction = $malfunction;
    }

    public function getMalfunctions($search = null)
    {
        $query = $this->malfunction::with('equipment', 'technician', 'ticket');

        if ($search) {
            $query->withSearch($search);
        }

        return $query;
    }

    public function findMalfunction($id)
    {
        return $this->malfunction::with('equipment', 'technician.user', 'ticket')->findOrFail($id);
    }


    public function addMalfunctionToDatabase($equipmentId): Malfunction
    {
        $malfunction = new Malfunction();
        $malfunction->equipment_id = $equipmentId;
        $malfunction->save();

        return $malfunction;
    }

    public function updateMalfunctionDetails(Malfunction $malfunction, array $validatedData)
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