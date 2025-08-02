<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'brand'
    ];

    public function notebooks()
    {
        return $this->belongsToMany(
            \App\Models\Notebook::class, 
            'accessory_notebook'
        );
    }
}
