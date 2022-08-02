<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProblema extends Model
{
    use HasFactory;

    protected $table = 'hd_tipo_problemas';

    protected $fillable = [
        'nome',
        'versao',
    ];
}
