<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'type', 'phone', 'email', 'password'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        // Antes de criar o utilizador, definir o 'type' como 'User' se não estiver definido.
        static::creating(function ($user) {
            if (empty($user->type)) {
                $user->type = 'User';
            }
        });
    }


//
//    public function newFromBuilder($attributes = [], $connection = null)
//    {
//        $instance = parent::newFromBuilder($attributes, $connection);
//
//        if (!empty($instance->type)) {
//            $class = '\\App\\Models\\' . ucfirst($instance->type);
//
//            if (class_exists($class)) {
//                return (new $class)->newFromBuilder($attributes, $connection);
//            }
//        }
//
//        return $instance;
//    }

    public function technician()
    {
        return $this->hasOne(Technician::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

}
