<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['title', 'description', 'open_date', 'close_date', 'wait_time', 'urgent', 'technician_id', 'malfunction_id'];

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function malfunction()
    {
        return $this->belongsTo(Malfunction::class);
    }
}
