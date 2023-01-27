<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\Usuario
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $telefone_1
 * @property bool|null $telefone_1_wa
 * @property string|null $ue
 * @property string|null $versao
 * @property string|null $remember_token
 * @property bool|null $app_admin
 * @property int|null $unidade_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Area[] $areas
 * @property-read int|null $areas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chamado[] $chamados
 * @property-read int|null $chamados_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Unidade|null $unidade
 * @method static \Database\Factories\UsuarioFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario query()
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereAppAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereTelefone1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereTelefone1Wa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereUe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereUnidadeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Usuario whereVersao($value)
 * @mixin \Eloquent
 */
class Usuario extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

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
        'telefone_1_wa' => 'boolean',
        'app_admin' => 'boolean',
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
     */
    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }
}
