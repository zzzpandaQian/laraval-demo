<?php

namespace App\Admin\Controllers;

use App\Models\SeoItem;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SeoItemController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'SEO';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SeoItem());

        $grid->column('id', __('ID'));
        $grid->column('seo_url', __('URL'));
        $grid->column('seo_title', __('页面标题'));
        $grid->column('created_at', __('创建时间'));

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('seo_url', 'URL');
            $filter->like('seo_title', '标题');
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(SeoItem::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('seo_url', __('URL'));
        $show->field('seo_title', __('页面标题'));
        $show->field('seo_keywords', __('关键词'));
        $show->field('seo_description', __('描述'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SeoItem());

        $form->text('seo_url', __('URL'));
        $form->text('seo_title', __('页面标题'));
        $form->text('seo_keywords', __('关键词'));
        $form->textarea('seo_description', __('描述'));

        return $form;
    }
}
