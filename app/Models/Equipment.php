<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';
    protected $fillable = ['type', 'manufacturer', 'model', 'room', 'serial_number', 'is_approved'];

    // Scope para ordenação
    public function scopeSortBy($query, $sort, $direction = 'asc'): void
    {
        if (in_array($sort, ['type', 'manufacturer', 'model', 'serial_number', 'room'])) {
            $query->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');
        }
    }

    // Scope para busca
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('type', 'like', '%' . $search . '%')
                ->orWhere('manufacturer', 'like', '%' . $search . '%')
                ->orWhere('model', 'like', '%' . $search . '%')
                ->orWhere('serial_number', 'like', '%' . $search . '%')
                ->orWhere('room', 'like', '%' . $search . '%');
        });
    }

    public function malfunctions()
    {
        return $this->hasMany(Malfunction::class);
    }



}

