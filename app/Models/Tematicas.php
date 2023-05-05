<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subtematicas;
use App\Models\Proyectos;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;


//use Illuminate\Database\Eloquent\SoftDeletes;

class Tematicas extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'thematics';

    protected $fillable = ['name'];

    public function subtematica(){
        return $this->hasMany(Subtematicas::class, 'thematic_id');
    }

    public function users(){
        return $this->hasMany(User::class, 'thematic_id', 'id');
    }

    public function proyectos(){
        return $this->hasMany(Proyectos::class, 'thematic_id', 'id');
    }


}
