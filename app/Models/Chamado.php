<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamado extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'hd_chamados';

    protected $dates = [
        'deleted_at',
    ];

    protected $casts = [
        'status' => 'integer',
        'anexos' => 'array',
    ];

    protected $fillable = [
        'tipo_problema_id',
        'problema_id',
        'usuario_id',
        'anexos',
        'status',
        'observacao',
        'versao',
        'title',
    ];

    public function tipo_problema()
    {
        return $this->belongsTo(TipoProblema::class, 'tipo_problema_id', 'id');
    }

    public function problema()
    {
        return $this->belongsTo(Problema::class, 'problema_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

}
