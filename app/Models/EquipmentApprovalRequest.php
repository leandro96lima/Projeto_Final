<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentApprovalRequest extends Model
{
    use HasFactory;

    protected $fillable = ['equipment_id', 'user_id', 'ticket_id', 'approved_by_admin_id', 'status', 'comments'];

    // Relacionamento com o ticket
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    // Relacionamento com o usuário que criou o ticket
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com o administrador que aprovou/rejeitou a solicitação
    public function approvedByAdmin()
    {
        return $this->belongsTo(User::class, 'approved_by_admin_id');
    }
}
