<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_department';
    protected $fillable = ['department_name', 'faculty_id', 'description'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id_faculty');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id', 'id_department');
    }
}
