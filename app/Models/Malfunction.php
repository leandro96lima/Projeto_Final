<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Malfunction extends Model
{

    use HasFactory;


    protected $fillable = ['status', 'cost', 'resolution_time', 'diagnosis', 'solution', 'equipment_id'];

    public function equipament(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
