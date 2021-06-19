<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    use HasFactory;

    protected $table        = 'hd_anexos';

    protected $casts        = [
        'restrito_a_grupos'   => 'array',
        'restrito_a_usuarios' => 'array',
        'temporario'          => 'boolean',
        'destruir_apos'       => 'datetime',
    ];

    protected $fillable     = [
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
