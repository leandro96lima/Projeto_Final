<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Malfunction extends Model
{
    protected $fillable = ['status', 'cost', 'resolution_time', 'diagnosis', 'solution', 'equipment_id'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
