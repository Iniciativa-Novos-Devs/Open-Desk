<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasUsuario extends Model
{
    use HasFactory;

    protected $table        = 'hd_areas_usuarios';

    protected $fillable     = [
        'usuario_id',
        'area_id',
    ];
}
