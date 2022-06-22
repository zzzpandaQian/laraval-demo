<?php

namespace App\Admin\Controllers;

use App\Models\Page;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Tree;

class PageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '页面管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Page);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('permalink', __('链接'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $active = config('array.active');
            $labelStyle = ($status == 1) ? 'success' : 'warning';
            return "<span class='label label-". $labelStyle ."'>" . $active[$status] . "</span>";
        });
        $grid->column('添加子页面')->display(function () {
            return ' <a href="' . route('pages.create', ['page_id' => $this->id]) . '" class="btn btn-xs btn-info" target="_blank">添加</a>';
        });

        $grid->actions(function ($actions) {
            $actions->disableView();
            // prepend一个操作
            $actions->prepend('<a href="' . route('pages.index', ['parent_id' => $actions->getKey()]) . '"><i class="glyphicon glyphicon-menu-hamburger"></i></a>');
        });
        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->column(1/2, function ($filter) {
                $filter->like('title', '标题');
                $filter->equal('status', '状态')->radio([''   => '全部'] + config('array.active'));
            });

            $filter->column(1/2, function ($filter) {
                $filter->like('permalink', '链接');
                $filter->equal('parent_id', '父级ID');
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
        $show = new Show(Page::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('标题'));
        $show->field('seo_title', __('SEO标题'));
        $show->field('seo_keywords', __('SEO关键字'));
        $show->field('seo_description', __('SEO描述'));
        $show->field('parent_id', __('父级ID'));
        $show->field('sort_order', __('排序'));
        $show->field('permalink', __('链接'));
        $show->field('content', __('内容'))->unescape();
        $show->field('status', __('状态'))->using(config('array.active'));
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
        $form = new Form(new Page);

        if (request('page_id')) {
            $page = Page::find(request('page_id'));
            $form->display('parent_id', '父级ID')->default($page->title);
            $form->hidden('parent_id')->default(request('page_id'));
        } else {
            $form->select('parent_id', '父级ID')->options(Page::selectOptions());
        }

        $form->text('title', __('标题'))->rules('required');
        $form->text('seo_title', __('SEO标题'));
        $form->text('seo_keywords', __('SEO关键字'));
        $form->textarea('seo_description', __('SEO描述'));
        $form->number('sort_order', __('排序序号'))->default(0);
        $form->text('permalink', __('链接'));
        $form->UEditor('content', __('内容'));
        $form->radio('status', __('状态'))->options(config('array.active'))->default('0');

        return $form;
    }

    protected function treeView()
    {
        return Page::tree(function (Tree $tree) {
            $tree->disableCreate();
            return $tree;
        });
    }

    public function getPageOptions()
    {
        return DB::table('pages')->select('id', 'title as text')->get();
    }
}
