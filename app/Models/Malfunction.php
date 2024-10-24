<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Malfunction extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'cost', 'resolution_time', 'diagnosis', 'solution', 'technician_id', 'equipment_id', 'urgent'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($malfunction) {
            if (empty($malfunction->status)) {
                $malfunction->status = 'open';
            }
        });
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }
}

