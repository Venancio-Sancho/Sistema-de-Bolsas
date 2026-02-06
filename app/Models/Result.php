<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $primaryKey = 'result_id';

    protected $fillable = [
        'application_id',
        'decision',
        'remarks',
        'result_date',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id', 'id_application');
    }
}
