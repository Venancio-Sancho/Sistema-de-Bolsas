<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'birth_date',
        'gender',
        'phone',
        'address',
        'student_type',
        'registration_date',
    ];

    protected $hidden = ['password'];
}
