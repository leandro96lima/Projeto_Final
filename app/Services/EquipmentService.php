<?php

namespace App\Services;

use App\Models\Equipment;
use App\Jobs\NotifyAdminsOfEquipment;
use App\Models\EquipmentApprovalRequest;

class EquipmentService
{

    public function getEquipments($request, $query){

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->search($search);
        }

        if ($request->filled('sort')) {
            $query->sortBy($request->sort, $request->direction);
        }

         $equipments = $query->paginate(20);

        return $equipments;
    }


    public function createEquipment($data)
    {
        // Verificação manual de duplicidade
        if (Equipment::where('type', $data['type'])
            ->where('serial_number', $data['serial_number'])->exists()) {
            return [
                'error' => 'Este número de série já existe para este tipo de equipamento.'
            ];
        }

        $equipment = Equipment::create($data);

        return $equipment;
    }

    public function handleApproval($request, $equipment)
    {
        // Enviar notificação para todos os admins
        NotifyAdminsOfEquipment::dispatch($equipment);
        $equipment->is_approved = false;
        $equipment->save();

        // Cria a solicitação de aprovação
        EquipmentApprovalRequest::create([
            'equipment_id' => $equipment->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        session()->put('from_equipment_controller', true);
    }
}
