<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeChangeRequest extends Model
{
    protected $fillable = ['user_id', 'requested_type', 'status', 'reason', 'processed_by_admin_id'];

    // Relacionamento com o administrador que processou a solicitação
    public function processedByAdmin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by_admin_id');
    }
}
