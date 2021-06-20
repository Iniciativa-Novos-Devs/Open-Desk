<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'hd_areas';

    protected $fillable     = [
        'sigla',
        'nome',
    ];

    public function atividades()
    {
        return $this->hasMany(Atividade::class, 'area_id');
    }

    public function atendentes()
    {
        return $this->belongsToMany(Usuario::class, 'hd_areas_usuarios', 'area_id', 'usuario_id');
    }
}
