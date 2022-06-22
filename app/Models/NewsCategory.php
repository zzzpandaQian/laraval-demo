<?php

namespace App\Models;

use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use ModelTree;

    protected $fillable = [
        'id', 'title','permalink','status', 'parent_id'
    ];

    protected $table="news_categories";

    public function news()
    {
        return $this->hasMany('App\Models\News');
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('order');
        $this->setTitleColumn('title');
    }

}
