<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Unidade
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $ue
 * @property string $nome
 * @property string|null $cidade
 * @property string|null $diretor
 * @property string|null $dir_adm
 * @property string|null $versao
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade query()
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereCidade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereDirAdm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereDiretor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereUe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Unidade whereVersao($value)
 * @mixin \Eloquent
 */
class Unidade extends Model
{
    use HasFactory;

    protected $table = 'hd_unidades';

    protected $fillable = [
        'ue',
        'nome',
        'cidade',
        'diretor',
        'dir_adm',
        'versao',
    ];
}
