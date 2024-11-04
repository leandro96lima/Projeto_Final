<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'urgent','open_date', 'close_date', 'wait_time', 'progress_date', 'resolution_time', 'user_id',  'technician_id', 'malfunction_id', ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->status)) {
                $ticket->status = 'open';
            }
        });
    }


    // Scope para filtrar por status
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope para filtrar por pesquisa
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->whereHas('malfunction', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('equipment', function($q) use ($search) {
                        $q->where('type', 'like', "%{$search}%");
                    });
            });
        });
    }

    public function scopeSortBy($query, $sort, $direction = 'asc')
    {
        // Adiciona joins necessários
        $query->leftJoin('malfunctions', 'malfunctions.id', '=', 'tickets.malfunction_id')
            ->leftJoin('equipments', 'equipments.id', '=', 'malfunctions.equipment_id')
            ->select('tickets.*'); // Seleciona as colunas de tickets

        // Mapeia os campos de ordenação
        $orderFields = [
            'equipment_type' => 'equipments.type',
            'wait_time' => 'tickets.wait_time'
        ];

        // Se o campo de ordenação é válido, aplica a ordenação
        if (isset($orderFields[$sort])) {
            return $query->orderBy($orderFields[$sort], $direction);
        }

        // Para outros campos, aplica a ordenação padrão
        return $query->orderBy($sort, $direction);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function malfunction()
    {
        return $this->belongsTo(Malfunction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
