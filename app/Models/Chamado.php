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
        'paused_at',
        'finished_at',
        'transferred_at',
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
        'atendente_id',
        'unidade_id',
        'paused_at',
        'finished_at',
        'transferred_at',
        'conclusion',
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

    public function atendente()
    {
        return $this->belongsTo(Usuario::class, 'atendente_id', 'id');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id', 'id');
    }

}
