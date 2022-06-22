<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    protected $fillable = [
        'id',
        'name',
        'sex',
        'address',
        'birthday',
        'best',
        'like',
        'message',
        'image',
        'status',
    ];

    public function getLikeAttribute($value)
    {
        return explode(',', $value);
    }

    public function setLikeAttribute($value)
    {
        $this->attributes['like'] = implode(',', $value);
    }

    public function setImageAttribute($image)
    {
        if (is_array($image)) {
            $this->attributes['image'] = json_encode($image);
        }
    }

    public function getImageAttribute($image)
    {
        return json_decode($image, true);
    }

    public function getImageUrlAttribute()
    {
        return getMoreImagesUrl($this->attributes['image']);
    }

}
