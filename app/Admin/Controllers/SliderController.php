<?php

namespace App\Admin\Controllers;

use App\Models\Slider;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SliderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '滑块列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Slider);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('button', __('按钮显示'))->display(function ($button) {
            if ($this->button == 1) {
                return "<span class='label label-success'>显示</span>";
            } else {
                return "<span class='label label-success'>不显示</span>";
            }
        });
        $grid->column('light', __('明/暗'))->display(function ($light) {
            if ($this->light == 'swiper-slide-dark') {
                return "<span class='label label-success'>暗</span>";
            } else {
                return "<span class='label label-success'>明</span>";
            }
        });
        $grid->column('position', __('字体位置'))->using(Slider::$positionMap);
        $grid->column('link', __('按钮链接'));
        $grid->column('sort_order', __('排序'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $active = config('array.active');
            $labelStyle = ($status == 1) ? 'success' : 'warning';
            return "<span class='label label-". $labelStyle ."'>" . $active[$status] . "</span>";
        });

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/2, function ($filter) {
                $filter->like('title', '标题');
                $filter->like('link', '按钮链接');
                $filter->equal('position', '字体位置')->radio(Slider::$positionMap);
                $filter->equal('status', '状态')->radio([''   => '全部'] + config('array.active'));
            });

            $filter->column(1/2, function ($filter) {
                $filter->like('sort_order', '排序');
                $filter->equal('light', '明/暗')->radio([
                    0 => '明',
                    1 => '暗',
                ]);
                $filter->equal('button', '显示按钮')->radio([
                    0 => '不显示',
                    1 => '显示',
                ]);
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
        $show = new Show(Slider::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('标题'));
        $show->field('image', __('背景图'))->image();
        $show->field('link', __('按钮链接'));
        $show->field('description', __('描述'))->unescape()->as(function ($description) {
            return "{$description}";
        });

        $show->field('button', __('显示按钮'))->using(['1' => '显示', '0' => '不显示'])->label();
        $show->field('light', __('明/暗'))->using(Slider::$lightMap)->label();
        $show->field('position', __('字体位置'))->using(Slider::$positionMap)->label();
        $show->field('sort_order', __('排序'));
        $show->field('status', __('状态'))->using(config('array.active'))->label();


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Slider);

        $form->text('title', __('标题'))->rules('required');
        $form->image('image', __('背景图'))->move('images/slider')->help("建议尺寸：1920x600");
        $form->url('link', __('按钮链接'));
        $form->textarea('description', __('描述'));
        $form->radio('button', __('按钮显示'))->options(['0'=> '不显示', '1' => '显示'])->default('0');
        $form->radio('light', __('明/暗'))->options(Slider::$lightMap);
        $form->radio('position', __('字体位置'))->options(Slider::$positionMap);
        $form->number('sort_order', __('排序'))->default(0);
        $form->radio('status', __('状态'))->options(config('array.active'))->default('0');


        return $form;
    }
}
