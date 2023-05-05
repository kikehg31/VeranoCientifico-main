<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Instituciones extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'institutions';

    protected $fillable = ['name'];

    public function users(){
        return $this->hasMany(User::class, 'institution_id', 'id');
    }

    public function proyectos(){
        return $this->hasMany(Proyectos::class, 'institution_id', 'id');
    }
}