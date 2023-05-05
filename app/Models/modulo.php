<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class modulo extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'c_modulo';

    protected $fillable = ['nombre', 'descripcion', 'key'];

    public function audit_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'audit_user_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($rec) {
            $rec->audit_user_id = auth()->user()->id;
        });
    }
}
