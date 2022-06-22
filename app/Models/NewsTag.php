<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsTag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'name'
    ];

    public function news()
    {
        return $this->belongsToMany('App\Models\News', 'news_has_tags');
    }

}
