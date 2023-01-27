<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TipoProblema
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $nome
 * @property string|null $versao
 * @method static \Illuminate\Database\Eloquent\Builder|TipoProblema newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TipoProblema newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TipoProblema query()
 * @method static \Illuminate\Database\Eloquent\Builder|TipoProblema whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoProblema whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoProblema whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoProblema whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TipoProblema whereVersao($value)
 * @mixin \Eloquent
 */
class TipoProblema extends Model
{
    use HasFactory;

    protected $table = 'hd_tipo_problemas';

    protected $fillable = [
        'nome',
        'versao',
    ];
}
