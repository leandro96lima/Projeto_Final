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

    public function getMalfunctionsFromDb($search = null, $status = null, $sort = null, $direction = 'asc')
    {
        $query = $this->malfunction::with('equipment', 'technician', 'ticket');

        // Aplicar busca se fornecida
        if ($search) $query->withSearch($search);
        // Aplicar ordenação se fornecida
        if ($sort) $query->sortBy($sort, $direction);
        // Aplicar filtro de status se fornecido
        if ($status) $query->withStatus($status);

        return $query;
    }
    public function findMalfunction($id)
    {
        return $this->malfunction::with('equipment', 'technician.user', 'ticket')->findOrFail($id);
    }


    public function addMalfunctiontoDb($equipmentId): Malfunction
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
