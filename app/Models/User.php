<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Instituciones;
use App\Models\Tematicas;
use App\Models\Expedientes;
//implements MustVerifyEmail


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles; //se copia de SPATIE PARA RELACIONAR USUARIOS CON
    //PERMISOS Y ROLES

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_rol',
        'name',
        'lastnamep',
        'lastnamem',
        'curp',
        'rfc',
        'email',
        'emailcon',
        'phone',
        'institution_id',
        'requestform',
        'thematic_id',
        'subthematic_id',
        'snilevel',
        'maxgrade',
        'invline',
        'job',
        'constancy',
        'photo',
        'password',
        'password_confirmation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function scopeFiltro($query, array $filtros)
    {
        $query->when($filtros['profile'] ?? null, function ($query, $profile) {
            $query->join('model_has_roles as mhs', 'users.id', '=', 'mhs.model_id');
            $query->where('mhs.role_id', $profile);
        });

        $query->when($filtros['search'] ?? null, function ($query, $search) {
            $tokens = explode(' ', mb_strtoupper($search));
            foreach ($tokens as $token) {
                $query->where(function ($query) use ($token) {
                    $query->where(DB::raw('name'), 'like', '%' . trim($token) . '%')
                        ->orWhere('email', 'like', '%' . trim($token) . '%');
                });
            }
        });

        return $query;
    }
    public function isSuperAdmin(): bool
    {
        return false;
    }

    public function getAllowedViews($module): Collection
    {
        return $this->getAllPermissions()->where('module_key', $module)->pluck('arg');
    }

    public function getRolesArray(): Collection
    {
        return $this->roles()->get()->mapWithKeys(function ($role) {
            return [$role['name'] => true];
        });
    }

    public function getPermissionArray(): Collection
    {
        return $this->getAllPermissions()->mapWithKeys(function ($permission) {
            return [$permission['name'] => true];
        });
    }

    public function institutions()
    {
        return $this->belongsTo(Instituciones::class, 'institution_id');
    }

    public function thematics()
    {
        return $this->belongsTo(Tematicas::class, 'thematic_id');
    }

    public function proyectos()
    {
        return $this->hasMany(Proyectos::class, 'user_id');
    }

    public function expediente()
    {
        return $this->hasOne(Expedientes::class, 'student_id');
    }

    public function revisor()
    {
        return $this->hasMany(Expedientes::class, 'rev_id');
    }

    public function proyecto()
    {
        return $this->hasMany(ProyectoUsuario::class, 'user_id');
    }

}
