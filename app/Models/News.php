<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use \Encore\Admin\Traits\Resizable;
    protected $fillable = [
        'id',
        'news_category_id',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'title',
        'image',
        'tag',
        'short',
        'content',
        'read_count',
        'status'
    ];

    public function getImageUrlAttribute()
    {
        return getimageUrl($this->image);
    }

    public function getImageThumbnailSmallUrlAttribute()
    {
        // 如果 image 字段本身就已经是完整的 url 就直接返回
        if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])) {
            return $this->attributes['image'];
        }

        return \Storage::disk('public')->url($this->thumbnail('small', 'image'));
    }

    public function newsCategory()
    {
        return $this->belongsTo('App\Models\NewsCategory');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\NewsTag', 'news_has_tags');
    }

    /**
     * 获取第一个Tag
     *
     * @return string
     */
    public function getFirstTagAttribute()
    {
        $tag = '';
        // foreach ($this->tag as $key => $value) {
        //     $tag = $value->name;
        //     break;
        // }
        // return $tag;

        if (is_array($tag) && !empty($tag)) {
            foreach ($this->tag as $key => $value) {
                $tag = $value->name;
                break;
            }
            return $tag;
        }
    }
}
