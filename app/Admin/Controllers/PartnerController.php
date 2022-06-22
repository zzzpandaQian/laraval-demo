<?php

namespace App\Admin\Controllers;

use App\Models\Partner;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PartnerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '合作伙伴';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Partner());

        $grid->column('id', __('ID'));
        $grid->column('title', __('标题'));
        $grid->column('link', __('链接'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $active = config('array.active');
            $labelStyle = ($status == 1) ? 'success' : 'warning';
            return "<span class='label label-". $labelStyle ."'>" . $active[$status] . "</span>";
        });

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('title', '标题');
            $filter->like('link', '链接');
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
        $show = new Show(Partner::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('image', __('Image'));
        $show->field('more_images', __('More images'));
        $show->field('description', __('Description'));
        $show->field('status', __('Status'));
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
        $form = new Form(new Partner());

        $form->text('title', __('标题'));
        $form->url('link', __('链接'));
        $form->image('image', __('图片'))->move('images/partner')->help("建议尺寸：300x200");
        $form->UEditor('description', __('描述'));
        $form->radio('status', __('状态'))->options(config('array.active'))->default(0);

        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });

        return $form;
    }
}
