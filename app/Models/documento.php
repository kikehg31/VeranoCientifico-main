<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DocumentoUsuario;
use App\Models\User;

class documento extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'documents';

    protected $fillable = ['name'];

    public function documentousuario(){
        return $this->hasMany(DocumentoUsuario::class, 'document_id');
    }

    public function usuario(){
        return $this->hasMany(User::class, 'user_id');
    }
}
