<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_course';

    protected $fillable = [
        'course_name',
        'department_id',
        'faculty_id',
        'description',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id_department');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id_faculty');
    }
}
