<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'birth_date',
        'gender',
        'phone',
        'address',
        'id_course',
        'level',
        'period', // novo campo
        'role',
        'registration_date',
        'access_level',
       
    ];

    protected $hidden = [
        'password',
        'remember_token',
         
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'id_user', 'id');
    }

    // Notificações do utilizador
public function notifications()
{
    return $this->hasMany(Notification::class);
}
}
