<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand', 'model', 'serial_number', 'processor',
        'memory', 'disk', 'price', 'price_string'
    ];

    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class);
    }

    public function accessories()
    {
        return $this->belongsToMany(
            \App\Models\Accessory::class, 
            'accessory_notebook'
        );
    }
}

