<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'open_date', 'close_date', 'wait_time', 'urgent', 'technician_id', 'malfunction_id'];

    public function setStatusAttribute($value)
    {
        // Se o status está sendo atualizado para "in progress"
        if ($value === 'in_progress' && $this->status === 'open') {
            // Calcula o tempo de espera em minutos desde a criação do ticket
            $this->wait_time = Carbon::now()->diffInMinutes($this->open_date);
        }

        // Atribui o novo status
        $this->attributes['status'] = $value;
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function malfunction()
    {
        return $this->belongsTo(Malfunction::class);
    }
}
