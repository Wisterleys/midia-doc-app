<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'user_document',
        'user_role',
        'brand',
        'model',
        'serial_number',
        'processor',
        'memory',
        'disk',
        'price',
        'price_string',
        'local',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
