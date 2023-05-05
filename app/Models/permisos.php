<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class permisos extends Model
{
    use HasFactory;
    protected $table = 'permissions';

    protected $fillable = ['name', 'guard_name', 'description','module_key'];
}
