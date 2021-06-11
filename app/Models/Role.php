<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table        = 'hd_roles';

    protected $primaryKey = 'uid';

    protected $fillable     = [
        'name',
        'uid',
    ];
}
