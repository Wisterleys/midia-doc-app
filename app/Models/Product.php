<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id', 'brand', 'model', 'serial_number',
        'processor', 'memory', 'disk', 'price',
        'price_string', 'local', 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
