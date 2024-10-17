<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{

    use HasFactory;
    protected $table = 'equipments';
    protected $fillable = ['type', 'manufacturer', 'model', 'room'];

    public function malfunctions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Malfunction::class);
    }
}
