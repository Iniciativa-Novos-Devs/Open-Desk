<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamado extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'hd_chamados';

    protected $dates = [
        'deleted_at',
    ];

    // protected $casts = [
    //     'status' => 'integer',
    // ];

    protected $fillable = [
        'tipo_problema_id',
        'problema_id',
        'usuario_id',
        'imagem_id',
        'status',
        'observacao',
        'versao',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id');
    }

}
