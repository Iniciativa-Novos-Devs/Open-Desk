<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Atividade
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $nome
 * @property int|null $area_id
 * @property string|null $versao
 * @property-read \App\Models\Area|null $area
 * @method static \Illuminate\Database\Eloquent\Builder|Atividade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Atividade newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Atividade query()
 * @method static \Illuminate\Database\Eloquent\Builder|Atividade whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Atividade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Atividade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Atividade whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Atividade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Atividade whereVersao($value)
 * @mixin \Eloquent
 */
class Atividade extends Model
{
    use HasFactory;

    protected $table = 'hd_atividades_area';

    protected $fillable = [
        'nome',
        'area_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }
}
