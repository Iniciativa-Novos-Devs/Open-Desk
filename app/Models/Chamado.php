<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamado extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'tipo_problema_id',
        'area_id',
        'problema_id',
        'usuario_id',
        'imagem_id',
        'status_id',
        'observacao',
        'versao',
    ];

}
