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
                ->orWhereHas('technician.user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                })
                ->orWhere('diagnosis', 'like', '%' . $search . '%');
        });
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

