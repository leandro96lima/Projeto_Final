<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';
    protected $fillable = ['type', 'manufacturer', 'model', 'room', 'serial_number'];

    public function malfunctions()
    {
        return $this->hasMany(Malfunction::class);
    }

}

