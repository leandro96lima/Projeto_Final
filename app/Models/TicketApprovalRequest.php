<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketApprovalRequest extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'user_id', 'approved_by_admin_id', 'status', 'comments'];

    // Relacionamento com o ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
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
