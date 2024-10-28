<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends User
{
    use HasFactory;

    protected $fillable = ['user_id', 'additional_admin_attributes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
