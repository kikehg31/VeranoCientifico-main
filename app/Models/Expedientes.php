<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Expedientes extends Model
{
    use HasFactory;


    protected $table = 'records';

    protected $fillable = ['student_id', 'rev_id', 'status', 'comments'];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function userRev()
    {
        return $this->belongsTo(User::class, 'rev_id');
    }
}
