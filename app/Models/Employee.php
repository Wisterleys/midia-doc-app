<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'cpf', 'role'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class);
    }
}
