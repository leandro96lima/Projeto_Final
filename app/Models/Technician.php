<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;
    protected $fillable = ['specialty', 'user_id'];

    // Scope para busca
    public function scopeSearch($query, $search)
    {
        return $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })->orWhere('specialty', 'like', '%' . $search . '%')
            ->orWhereHas('tickets', function ($q) use ($search) {
                $q->where('status', 'like', '%' . $search . '%'); // Exemplo se quiser filtrar tickets por status
            });
    }


    // Scope para ordenação
    public function scopeSortBy($query, $sortField, $sortDirection = 'asc')
    {
        if ($sortField === 'name' || $sortField === 'email') {
            $query->join('users', 'technicians.user_id', '=', 'users.id')
                ->select('technicians.*') // Para evitar ambiguidade
                ->orderBy('users.' . $sortField, $sortDirection);
        } elseif ($sortField === 'specialty') {
            $query->orderBy('specialty', $sortDirection);
        } elseif ($sortField === 'tickets_count') {
            $query->withCount('tickets')->orderBy('tickets_count', $sortDirection);
        }
    }


    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function malfunction()
    {
        return $this->hasMany(Malfunction::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
