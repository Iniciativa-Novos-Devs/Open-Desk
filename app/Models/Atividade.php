<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Atividade extends Model
{
    use HasFactory;

    protected $table = 'hd_atividades_area';

    protected $fillable     = [
        'nome',
        'area_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }


    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'hd_atividade_areas_usuarios', 'atividades_area_id', 'usuario_id');
    }
}
