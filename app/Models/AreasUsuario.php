<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AreasUsuario
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $usuario_id
 * @property int $area_id
 * @method static \Illuminate\Database\Eloquent\Builder|AreasUsuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AreasUsuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AreasUsuario query()
 * @method static \Illuminate\Database\Eloquent\Builder|AreasUsuario whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreasUsuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreasUsuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreasUsuario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AreasUsuario whereUsuarioId($value)
 * @mixin \Eloquent
 */
class AreasUsuario extends Model
{
    use HasFactory;

    protected $table = 'hd_areas_usuarios';

    protected $fillable = [
        'usuario_id',
        'area_id',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $existent_data = $model
                ->where('usuario_id', $model->usuario_id)
                ->where('area_id', $model->area_id)
                ->first();

            if ($existent_data) {
                return false;
            }
        });
    }
}
