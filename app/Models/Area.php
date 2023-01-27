<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Area
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $sigla
 * @property string $nome
 * @property string|null $versao
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Usuario[] $atendentes
 * @property-read int|null $atendentes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Atividade[] $atividades
 * @property-read int|null $atividades_count
 * @method static \Illuminate\Database\Eloquent\Builder|Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereSigla($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereVersao($value)
 * @mixin \Eloquent
 */
class Area extends Model
{
    use HasFactory;

    protected $table = 'hd_areas';

    protected $fillable = [
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
