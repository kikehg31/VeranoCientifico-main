<?php

namespace App\Models;

use App\Models\User;
use App\Models\Tematicas;
use App\Models\Subtematicas;
use App\Models\Instituciones;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proyectos extends Model
{
    use HasFactory;
    protected $table = 'proyectos';
    use HasRoles; 
    use SoftDeletes;

    protected $fillable = [
        'title',
        'studentnum',
        'thematic_id',
        'subthematic_id',
        'generalobject',
        'modality',
        'requirements',
        'keywords',
        'students',
        'institution_id',
        'user_id',
    ];

    public function thematics()
    {
        return $this->belongsTo(Tematicas::class, 'thematic_id');
    }

    public function subthematics()
    {
        return $this->belongsTo(Subtematicas::class, 'subthematic_id');
    }

    public function institutions()
    {
        return $this->belongsTo(Instituciones::class, 'institution_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'proyecto_usuarios', 'proyecto_id',  'user_id');
    }




}
