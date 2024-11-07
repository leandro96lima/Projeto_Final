<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Malfunction extends Model
{
    use HasFactory;

    protected $fillable = ['cost', 'diagnosis', 'solution', 'technician_id', 'equipment_id'];


    public function scopeWithSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->whereHas('equipment', function ($q) use ($search) {
                $q->where('type', 'like', '%' . $search . '%');
            })
                ->orWhereHas('ticket.technician.user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('diagnosis', 'like', '%' . $search . '%')
                ->orWhereHas('ticket', function ($q) use ($search) {
                    $q->where('status', 'like', '%' . $search . '%'); // Add this line to include ticket status in the search
                });
        });
    }

    public function scopeWithStatus($query, $status)
    {
        return $query->whereHas('ticket', function($q) use ($status) {
            $q->where('tickets.status', $status);
        });
    }


    public function scopeSortBy($query, $sort, $direction = 'asc')
    {
        // Adiciona joins necessários
        $query->leftJoin('tickets', 'tickets.malfunction_id', '=', 'malfunctions.id')
            ->leftJoin('equipments', 'equipments.id', '=', 'malfunctions.equipment_id')
            ->leftJoin('users as technicians', 'technicians.id', '=', 'malfunctions.technician_id') // Junção com a tabela de usuários
            ->select('malfunctions.*', 'equipments.type as equipment_type', 'tickets.status as ticket_status', 'tickets.resolution_time', 'technicians.name as technician_name');

        // Mapeia os campos de ordenação
        $orderFields = [
            'equipment_type' => 'equipments.type',
            'status' => 'tickets.status',
            'technician_name' => 'technicians.name', // Acesso ao nome do técnico
            'resolution_time' => 'tickets.resolution_time'
        ];

        // Verifica se o campo de ordenação é válido
        if (array_key_exists($sort, $orderFields)) {
            return $query->orderBy($orderFields[$sort], $direction);
        }

        // Ordena por coluna padrão
        return $query->orderBy($sort, $direction);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }
}

