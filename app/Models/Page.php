<?php

namespace App\Models;

use Illuminate\Support\Str;
use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use ModelTree, AdminBuilder;

    protected $fillable = [
        'title',
        'parent_id',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'sort_order',
        'permalink',
        'content',
        'status',
    ];

    protected $table = 'pages';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('sort_order');
        $this->setTitleColumn('title');
    }
}
