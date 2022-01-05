<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamado extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'hd_chamados';

    protected $appends = [
        'status_name',
    ];

    protected $dates = [
        'deleted_at',
        'paused_at',
        'finished_at',
        'transferred_at',
        'homologado_em',
    ];

    protected $casts = [
        'status' => 'integer',
        'anexos' => AsCollection::class,
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
        'area_id',
        'homologado_por',              //Usuario que homologou
        'homologado_em',               //Data da homologação
        'homologacao_avaliacao',       //Avaliação do homologador de 1 a 5
        'homologacao_observacao_fim',  //Mensagem opcional do homologador
        'homologacao_observacao_back', //Mensagem obrigatória do homologador CASO O CHAMADO NÃO ESTEJA CONCLUÍDO
    ];

    public function getStatusNameAttribute()
    {
        if(!$this->status ?? null)
            return null;

        return StatusEnum::getState($this->status);
    }

    public function tipo_problema()
    {
        return $this->belongsTo(TipoProblema::class, 'tipo_problema_id', 'id');
    }

    public function problema()
    {
        return $this->belongsTo(Problema::class, 'problema_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

    public function homologadoPor()
    {
        return $this->belongsTo(Usuario::class, 'homologado_por', 'id');
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
