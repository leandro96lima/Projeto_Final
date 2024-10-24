<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeChangeRequest extends Model
{
    protected $fillable = ['user_id', 'requested_type', 'status', 'reason'];
}
