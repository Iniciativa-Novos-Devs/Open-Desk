<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRole extends Model
{
    use HasFactory;

    protected $table        = 'hd_usuario_roles';

    protected $fillable     = [
        'usuario_id',
        'role_uid',
    ];
}
