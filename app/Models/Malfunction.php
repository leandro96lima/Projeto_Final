<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Malfunction extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'cost', 'resolution_time', 'diagnosis', 'solution', 'technician_id', 'equipment_id'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class); // Certifique-se de que a relação está correta
    }
}

