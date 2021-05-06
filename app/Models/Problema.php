<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problema extends Model
{
    use HasFactory;

    protected $table = 'hd_problemas';
    protected $fillable = [
        'descricao' ,
        'atividade_area_id',
    ];

    public function atividade()
    {
        return $this->belongsTo(\App\Models\Atividade::class, 'atividade_area_id', 'id');
    }
}
