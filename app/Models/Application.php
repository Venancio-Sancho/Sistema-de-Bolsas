<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';
    protected $primaryKey = 'id_application';

    protected $fillable = [
        'id_user',
        'id_scholarship',
        'snapshot_course',
        'snapshot_year',
        'snapshot_period',
        'application_date',
        'status',
        'bilhete_path',
        'atestado_pobreza_path',
        'declaracao_bairro_path',
        'declaracao_agregado_path',
        'declaracao_rendimento_path',
        'aproveitamento_path',
    ];

   public function user()
    {
        // Certifique-se de que o Model de Usuário está correto (geralmente App\Models\User)
        // E a chave estrangeira usada é 'id_user' (campo na tabela applications)
        // E a chave primária no modelo User é 'id'
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Relacionamento: Uma Candidatura pertence a uma Bolsa.
     */
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'id_scholarship', 'id');
    }
}
