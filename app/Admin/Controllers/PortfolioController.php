<?php

namespace App\Admin\Controllers;

use App\Models\Portfolio;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PortfolioController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '项目列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Portfolio);

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('sub_title', __('副标题'));
        $grid->column('image', __('背景图'))->display(function ($image) {
            return '<img src="' . $this->imageUrl . '" width="50" height="50"></a>';
        });
        $grid->column('created_at', __('创建时间'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $active = config('array.active');
            $labelStyle = ($status == 1) ? 'success' : 'warning';
            return "<span class='label label-" . $labelStyle . "'>" . $active[$status] . "</span>";
        });

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1 / 2, function ($filter) {
                $filter->like('title', '标题');
                $filter->equal('status', '状态')->radio([''   => '全部'] + config('array.active'));
            });

            $filter->column(1 / 2, function ($filter) {
                $filter->like('sub_title', '副标题');
            });
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
        $show = new Show(Portfolio::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('标题'));
        $show->field('sub_title', __('副标题'));
        $show->field('image', __('背景图'))->image();
        $show->field('content', __('内容'))->unescape();
        $show->field('status', __('是否使用'))->using(config('array.active'))->label();

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Portfolio);

        $form->text('title', __('标题'))->rules('required|min:3');
        $form->text('sub_title', __('副标题'));
        $form->image('image', __('背景图'))->thumbnail([
            'small'  => [500, 250, 'fit'],
            'large'  => [1000, 660, 'fit'],
        ])->help('建议尺寸1000*660');
        $form->multipleImage('more_images', __('多图'))->move('images/portfolio')->removable()->thumbnail([
            'large'  => [540, 540, 'fit'],
        ])->help('建议尺寸540*540');

        $form->hasMany('introduction', function ($form) {
            $form->text('title', __('标题'));
            $form->radio('content', __('内容'))->options(config('array.active'))->default('0');
        });

        $form->UEditor('content', __('内容'));
        $form->radio('status', __('是否使用'))->options(config('array.active'))->default('0');

        return $form;
    }
}
