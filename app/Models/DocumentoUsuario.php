<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentoUsuario extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'documents_user';
    protected $fillable = ['user_id', 'document_id','name_doc', 'path', 'record_id'];
}
