<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Anexo
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $path
 * @property string|null $extension
 * @property string|null $mime_type
 * @property array|null $restrito_a_grupos
 * @property array|null $restrito_a_usuarios
 * @property bool|null $temporario
 * @property \Illuminate\Support\Carbon|null $destruir_apos
 * @property int|null $created_by_id
 * @property string|null $name
 * @property string|null $size
 * @property-read \App\Models\Usuario|null $created_by
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereDestruirApos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereRestritoAGrupos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereRestritoAUsuarios($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereTemporario($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anexo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Anexo extends Model
{
    use HasFactory;

    protected $table = 'hd_anexos';

    protected $casts = [
        'restrito_a_grupos' => 'array',
        'restrito_a_usuarios' => 'array',
        'temporario' => 'boolean',
        'destruir_apos' => 'datetime',
    ];

    protected $fillable = [
        'path',
        'extension',
        'mime_type',
        'restrito_a_grupos',
        'restrito_a_usuarios',
        'temporario',
        'destruir_apos',
        'created_by_id',
        'name',
        'size',
    ];

    public function created_by()
    {
        return $this->belongsTo(Usuario::class, 'created_by_id', 'id');
    }
}
