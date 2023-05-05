<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Tematicas;
use Illuminate\Support\Collection;

class Subtematicas extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'subthematics';

    protected $fillable = ['name', 'thematic_id'];

   
    public function tematica(){
        return $this->belongsTo(Tematicas::class, 'thematic_id');
    }

    public function proyectos(){
        return $this->hasMany(Proyectos::class, 'subthematic_id', 'id');
    }

}

