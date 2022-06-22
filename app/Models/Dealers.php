<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealers extends Model
{
    protected $fillable = [
        'id',
        'area_id',
        'title',
        'tel',
        'description',
        'longitude',
        'latitude',
    ];

    public function area()
    {
        return $this->belongsTo('App\Models\Area');
    }
}
