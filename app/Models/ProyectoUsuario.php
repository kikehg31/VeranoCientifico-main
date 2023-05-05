<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProyectoUsuario extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'proyecto_id',
        'status',
        'priority',
        'teach_id'
    ];


    public function alumnos()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyectos::class, 'proyecto_id');
    }

}
