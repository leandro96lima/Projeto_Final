<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends User
{

    use HasFactory;
    protected $fillable = ['specialty', 'user_id'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
