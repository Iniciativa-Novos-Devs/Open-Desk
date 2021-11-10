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

    protected $appends = [
        'name',
        'uid',
    ];

    /**
     * Get all of the usuarios for the UsuarioRole
     *
     */
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id', 'usuario_id');
    }

    /**
     * Get the role that owns the UsuarioRole
     *
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_uid', 'uid');
    }

    //return role name
    public function getNameAttribute()
    {
        return $this->role->name;
    }

    //return role id
    public function getUidAttribute()
    {
        return $this->role->uid;
    }

}
