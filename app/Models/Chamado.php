<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chamado extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $dates = [
        'deleted_at'
    ];
    
}