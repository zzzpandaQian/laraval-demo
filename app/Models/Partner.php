<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'id',
        'title',
        'link',
        'image',
        'description',
        'status'
    ];

    public function getImageUrlAttribute()
    {
        return getimageUrl($this->image);
    }

}
