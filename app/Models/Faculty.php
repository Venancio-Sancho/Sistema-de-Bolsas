<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_faculty';
    protected $fillable = ['faculty_name', 'description'];

    public function departments()
    {
        return $this->hasMany(Department::class, 'faculty_id', 'id_faculty');
    }
}
