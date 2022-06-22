<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

    const POSITION_CENTER = 'intro-text-center';
    const POSITION_RIGHT  = 'intro-text-right';
    const POSITION_LEFT   = 0;

    public static $positionMap = [
        self:: POSITION_LEFT    => '居左',
        self:: POSITION_CENTER    => '居中',
        self:: POSITION_RIGHT    => '居右',
    ];

    const   LIGHT_DARK = 'swiper-slide-dark';
    const   LIGHT_LIGHT   = 0;

    public static $lightMap = [
        self::  LIGHT_LIGHT    => '明',
        self::  LIGHT_DARK    => '暗',
    ];
    protected $fillable = [
        'title',
        'image',
        'link',
        'description',
        'status',
        'button',
        'light',
        'position',
        'sort_order',
    ];

    public function getImageUrlAttribute()
    {
        return getimageUrl($this->image);
    }

}
