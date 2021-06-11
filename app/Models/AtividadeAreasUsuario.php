<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeAreasUsuario extends Model
{
    use HasFactory;

    protected $table        = 'hd_atividade_areas_usuarios';

    protected $fillable     = [
        'usuario_id',
        'atividades_area_id',
    ];
}
