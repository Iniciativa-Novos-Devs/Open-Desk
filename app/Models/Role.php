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

    /**
     * Get all of the usuario_roles for the UsuarioRole
     *
     */
    public function usuario_roles()
    {
        return $this->hasMany(UsuarioRole::class, 'role_uid', 'uid');
    }
}
