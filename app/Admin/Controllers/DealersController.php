<?php

namespace App\Admin\Controllers;

use App\Models\Area;
use App\Models\Dealers;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DealersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '经销商';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Dealers());

        $grid->column('id', __('ID'));
        $grid->column('area.title', __('区域'));
        $grid->column('title', __('经销商'));
        $grid->column('tel', __('电话'));
        $grid->column('created_at', __('创建时间'));

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('title', '经销商');
            $filter->like('tel', '电话');
            $filter->equal('area_id', '产品分类')->select(Area::where('status', 1)->pluck('title', 'id'));

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
        $show = new Show(Dealers::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('area_id', __('Area id'));
        $show->field('title', __('Title'));
        $show->field('tel', __('Tel'));
        $show->field('description', __('Description'));
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
        $form = new Form(new Dealers());

        $form->select('area_id', __('区域'))->options(
            function ($area_id) {
                return Area::where('status', 1)->pluck('title', 'id');
            }
        );
        $form->text('title', __('经销商'))->rules('required');
        $form->text('tel', __('电话'));
        $form->textarea('description', __('描述'));

        $form->latlong('latitude', 'longitude', '经纬度')->height(500);

        return $form;
    }
}
