<?php

namespace App\Models;

use App\Enums\OrigemDoProblemaEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Chamado
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $tipo_problema_id
 * @property int $problema_id
 * @property int $usuario_id
 * @property mixed|null $anexos
 * @property int $status
 * @property string $observacao
 * @property string|null $versao
 * @property string|null $title
 * @property int|null $unidade_id
 * @property int|null $atendente_id
 * @property \Illuminate\Support\Carbon|null $paused_at
 * @property \Illuminate\Support\Carbon|null $finished_at
 * @property \Illuminate\Support\Carbon|null $transferred_at
 * @property string|null $conclusion
 * @property int|null $area_id
 * @property int|null $homologado_por
 * @property \Illuminate\Support\Carbon|null $homologado_em
 * @property int|null $homologacao_avaliacao
 * @property string|null $homologacao_observacao_fim
 * @property string|null $homologacao_observacao_back
 * @property int|null $origem_do_problema
 * @property-read \App\Models\Area|null $area
 * @property-read \App\Models\Usuario|null $atendente
 * @property-read mixed $origem
 * @property-read mixed $status_name
 * @property-read \App\Models\Usuario|null $homologadoPor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChamadoLog[] $logs
 * @property-read int|null $logs_count
 * @property-read \App\Models\Problema $problema
 * @property-read \App\Models\TipoProblema|null $tipo_problema
 * @property-read \App\Models\Unidade|null $unidade
 * @property-read \App\Models\Usuario $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado newQuery()
 * @method static \Illuminate\Database\Query\Builder|Chamado onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereAnexos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereAtendenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereConclusion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereFinishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereHomologacaoAvaliacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereHomologacaoObservacaoBack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereHomologacaoObservacaoFim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereHomologadoEm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereHomologadoPor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereObservacao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereOrigemDoProblema($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado wherePausedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereProblemaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereTipoProblemaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereTransferredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereUnidadeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereUsuarioId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chamado whereVersao($value)
 * @method static \Illuminate\Database\Query\Builder|Chamado withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Chamado withoutTrashed()
 * @mixin \Eloquent
 */
class Chamado extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'hd_chamados';

    protected $appends = [
        'origem',
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
        'origem_do_problema',          //Origem do problema
    ];

    public function getStatusNameAttribute()
    {
        if (! $this->status ?? null) {
            return null;
        }

        return StatusEnum::getValue($this->status);
    }

    public function getOrigemAttribute()
    {
        if (! $this->origem_do_problema ?? null) {
            return null;
        }

        return OrigemDoProblemaEnum::getValue($this->origem_do_problema);
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

    /**
     * Get all of the logs for the Chamado
     */
    public function logs()
    {
        return $this->hasMany(ChamadoLog::class);
    }
}
