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


    public function createMalfunction($equipmentId): Malfunction
    {
        $malfunction = new Malfunction();
        $malfunction->equipment_id = $equipmentId;
        $malfunction->save();

        return $malfunction;
    }

    public function updateMalfunction(Malfunction $malfunction, array $data)
    {
        try {
            return $malfunction->update($data);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao atualizar a avaria: " . $e->getMessage());
        }
    }

    public function deleteMalfunction(Malfunction $malfunction)
    {
        return $malfunction->delete();
    }
}
