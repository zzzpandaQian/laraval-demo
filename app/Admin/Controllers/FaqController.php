<?php

namespace App\Admin\Controllers;

use App\Models\Faq;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\Post\BatchReplicate;
use Encore\Admin\Controllers\AdminController;

class FaqController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Faq';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Faq());

        $grid->column('id', __('ID'));
        $grid->column('title', __('标题'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $active = config('array.active');
            $labelStyle = ($status == 1) ? 'success' : 'warning';
            return "<span class='label label-" . $labelStyle . "'>" . $active[$status] . "</span>";
        });

        $grid->batchActions(function ($batch) {
            $batch->add(new BatchReplicate());
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('title', '标题');
            $filter->equal('status', '状态')->radio([''   => '全部'] + config('array.active'));
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
        $show = new Show(Faq::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Faq());

        $form->text('title', __('标题'));
        $form->UEditor('description', __('描述'));
        $form->radio('status', __('状态'))->options(config('array.active'))->default(0);

        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });

        return $form;
    }
}
