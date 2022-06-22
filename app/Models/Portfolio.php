<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use \Encore\Admin\Traits\Resizable;

    protected $fillable = [
        'title',
        'sub_title',
        'content',
        'image',
        'more_images',
        'introduction',
        'status',
    ];

    public function introduction()
    {
        return $this->hasMany(PortfolioIntroduction::class);
    }

    public function project()
    {
        return $this->hasMany(Project::class);
    }

    public function getImageUrlAttribute()
    {
        return getimageUrl($this->image);
    }

    public function setMoreImagesAttribute($more_images)
    {
        if (is_array($more_images)) {
            $this->attributes['more_images'] = json_encode($more_images);
        }
    }

    public function getMoreImagesAttribute($more_images)
    {
        return json_decode($more_images, true);
    }

    public function getMoreImagesUrlAttribute()
    {
        return getMoreImagesUrl($this->attributes['more_images']);
    }

    public function getMoreImagesUrlThumbAttribute()
    {
        return getMoreImagesUrlThumb($this->attributes['more_images']);
    }
}
