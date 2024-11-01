<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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


    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function malfunction()
    {
        return $this->belongsTo(Malfunction::class);
    }
}
