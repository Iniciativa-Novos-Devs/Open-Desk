<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamadoLog extends Model
{
    use HasFactory;

    protected $table = 'hd_chamado_logs';

    protected $fillable     = [
        'content',
        'type',
        'chamado_id',
        'atendente_id',
        'user_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id', 'id');
    }
}
