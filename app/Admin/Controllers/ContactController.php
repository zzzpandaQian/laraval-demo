<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Contact;
use App\Exports\ContactExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Admin\Extensions\ContactExporter;
use Encore\Admin\Controllers\AdminController;

class ContactController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '联系';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Contact);

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('名称'));
        $grid->column('email', __('邮箱'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $deal_with = config('array.deal_with');
            $labelStyle = ($status==1) ? 'success' : 'warning';
            return "<span class='label label-". $labelStyle ."'>" . $deal_with[$status] . "</span>";
        });
        $grid->exporter(new ContactExporter());

        $grid->disableCreateButton();
        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('name', '名称');
            $filter->like('email', '邮箱');
            $filter->equal('status', '状态')->radio([''   => '全部'] + config('array.deal_with'));
        });

        // 自定义导出
        $grid->disableExport();
        $grid->tools(function ($tools) {
            $tools->append('<a href="' . route('contacts.export') . '" class="btn btn-sm btn-info" target="_blank"><i class="fa fa-download"></i> 导出全部</a>');
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
        $show = new Show(Contact::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('名称'));
        $show->field('email', __('邮箱'));
        $show->field('message', __('信息'));
        $show->field('status', __('状态'))->using(config('array.deal_with'));
        $show->field('updated_at', __('更新时间'));
        $show->field('created_at', __('更新时间'));


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Contact);

        $form->display('name', __('名称'))->rules('required');
        $form->display('email', __('邮箱'));
        $form->display('message', __('信息'));
        $form->radio('status', __('是否发布'))->options(config('array.deal_with'))->default('0');

        return $form;
    }

    public function export()
    {
        return Excel::download(new ContactExport, 'contact.xlsx');
    }
}
