<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
