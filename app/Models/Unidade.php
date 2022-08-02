<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
