<?php

namespace App\Admin\Controllers;

use App\Models\LaravelSms;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LaravelSmsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '短信记录';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new LaravelSms);

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('ID'));
        $grid->column('status', __('状态'))->display(function () {
            if ($this->sent_time != 0) {
                return "<span class='label label-success'>成功</span>";
            } else {
                return "<span class='label label-warning'>失败</span>";
            }
        });

        $grid->column('to', __('手机号'));
        $grid->column('temp_id', __('存储模板标记'));
        $grid->column('data', __('模板数据'));
        $grid->column('content', __('内容'));
        $grid->column('voice_code', __('验证码'))->width(80);
        $grid->column('fail_times', __('失败次数'));
        $grid->column('last_fail_time', __('最后失败时间'));
        $grid->column('sent_time', __('成功时间'));
        $grid->disableCreateButton();

        //不显示操作里的删除和修改
        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableEdit();
            $actions->disableDelete();
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
        $show = new Show(LaravelSms::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('to', __('手机号'));
        $show->field('temp_id', __('存储模板标记'));
        $show->field('data', __('模板数据'));
        $show->field('content', __('内容'));
        $show->field('voice_code', __('验证码'));
        $show->field('fail_times', __('失败次数'));
        $show->field('last_fail_time', __('最后失败时间'));
        $show->field('sent_time', __('成功时时间'));
        $show->field('result_info', __('日志'));
        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new LaravelSms);
        return $form;
    }
}
