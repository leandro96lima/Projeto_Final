<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = ['type', 'manufacturer', 'model', 'room'];

    public function malfunctions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Malfunction::class);
    }
}
