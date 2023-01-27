<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Problema
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $descricao
 * @property int|null $atividade_area_id
 * @property string|null $versao
 * @property-read Atividade|null $atividade
 * @method static \Illuminate\Database\Eloquent\Builder|Problema newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Problema newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Problema query()
 * @method static \Illuminate\Database\Eloquent\Builder|Problema whereAtividadeAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problema whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problema whereDescricao($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problema whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problema whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problema whereVersao($value)
 * @mixin \Eloquent
 */
class Problema extends Model
{
    use HasFactory;

    protected $table = 'hd_problemas';

    protected $fillable = [
        'descricao',
        'atividade_area_id',
    ];

    public function atividade()
    {
        return $this->belongsTo(Atividade::class, 'atividade_area_id', 'id');
    }
}
