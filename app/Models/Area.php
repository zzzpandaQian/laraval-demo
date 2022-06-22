<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        'id',
        'title',
        'image',
        'status'
    ];

    public function dealers()
    {
        return $this->hasMany('App\Models\Dealers');
    }
}
