<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'hd_usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'telefone_1',
        'telefone_1_wa',
        'ue',
        'versao',
        'app_admin',
        'unidade_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'telefone_1_wa'     => 'boolean',
        'app_admin'         => 'boolean',
    ];

    /**
     * Get all of the comments for the Usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chamados()
    {
        return $this->hasMany(Chamado::class, 'usuario_id', 'id');
    }

    public function areas()
    {
        return $this->belongsToMany(
            Area::class,
            'hd_areas_usuarios',
            'usuario_id',
            'area_id'
        )->withPivot('area_id');
    }

    /**
     * Get the unidade that owns the Usuario
     *
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }
}
