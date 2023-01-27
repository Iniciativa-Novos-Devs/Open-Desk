<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ChamadoLog
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $content
 * @property int $type
 * @property int $chamado_id
 * @property int|null $atendente_id
 * @property int|null $user_id
 * @property-read \App\Models\Usuario|null $usuario
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog whereAtendenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog whereChamadoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChamadoLog whereUserId($value)
 * @mixin \Eloquent
 */
class ChamadoLog extends Model
{
    use HasFactory;

    protected $table = 'hd_chamado_logs';

    protected $fillable = [
        'content',
        'type',
        'chamado_id',
        'atendente_id',
        'user_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id', 'id');
    }
}
