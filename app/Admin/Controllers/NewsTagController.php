<?php

namespace App\Admin\Controllers;

use App\Models\NewsTag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;

class NewsTagController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '标签';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NewsTag);


        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('name', '名称');
        });

        $grid->column('id', __('ID'));
        $grid->column('name', __('名称'));

        $grid->filter(function ($filter) {
            $filter->like('name', '名称');
            $filter->scope('trashed', '回收站')->onlyTrashed();
        });

        $grid->actions(
            function ($actions) {
                $actions->disableView();
                // 添加操作
                if ($actions->row->deleted_at > 0) {
                    $actions->prepend('<a href="' . route('newstags.restore', ['id' => $this->row->id]) . '"><i class="fa fa-reply"></i></a>');
                }
            }
        );

        $grid->column( __('查看新闻'))->display(function () {
            return ' <a href="' . route('news.index', ['news_tag_id' => $this->id]) . '" target="_blank" class="label label-info">查看新闻</a>';
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
        $show = new Show(NewsTag::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('名称'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new NewsTag);

        $form->text('name', __('名称'))->rules('required');
        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });

        return $form;
    }

    public function restore(Request $request)
    {
        NewsTag::onlyTrashed()->find($request->input('id'))->restore();
        return redirect()->route('newstags.index');
    }
}
