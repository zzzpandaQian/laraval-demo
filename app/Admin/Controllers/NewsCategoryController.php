<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Tree;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Widgets\Table;
use Encore\Admin\Controllers\AdminController;

class NewsCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '新闻分类';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NewsCategory);

        $grid->column('id', __('ID'));
        // $grid->column('title', __('标题'));
        $grid->column('title', __('标题'))->expand(function ($model) {
            $news = $model->news()->take(10)->get()->map(function ($comment) {
                return $comment->only(['id', 'title', 'status', 'created_at']);
            });

            return new Table(['ID', '标题', '状态', '发布时间'], $news->toArray());
        });
        $grid->column('permalink', __('固定连接'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $active = config('array.active');
            $labelStyle = ($status == 1) ? 'success' : 'warning';
            return "<span class='label label-" . $labelStyle . "'>" . $active[$status] . "</span>";
        });

        $grid->column(__('查看新闻'))->display(function () {
            return ' <a href="' . route('news.index', ['news_category_id' => $this->id]) . '" target="_blank" class="label label-info">查看新闻</a>';
        });

        $grid->column('添加子分类')->display(function () {
            return ' <a href="' . route('news-categories.create', ['news_category_id' => $this->id]) . '" class="btn btn-xs btn-info">添加</a>';
        });

        // $grid->actions(
        //     function (Grid\Displayers\Actions $actions) {
        //         $actions->disableView();
        //         $actions->prepend('<a href="' . route('news.index', ['news_category_id' => $actions->getKey()]) . '" target="_blank"><i class="glyphicon glyphicon-eye-open" title="查看新闻"></i></a>');
        //     }
        // );
        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('name', '标题');
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
        $show = new Show(NewsCategory::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('name', __('标题'));
        $show->field('permalink', __('固定连接'))->link();
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
        $form = new Form(new NewsCategory);

        if (request('news_category_id')) {
            $news_category = NewsCategory::find(request()->news_category_id);
            $form->display('parent_id', '父级分类')->default($news_category->title);
            $form->hidden('parent_id')->default(request('news_category_id'));
        } else {
            $form->select('parent_id', '父级分类')->options(NewsCategory::selectOptions());
        }

        $form->text('title', __('标题'))->rules('required');
        $form->text('permalink', __('固定连接'));
        $form->radio('status', __('状态'))->options(config('array.active'))->default('0');

        return $form;
    }

    // protected function treeView()
    // {
    //     return NewsCategory::tree(function (Tree $tree) {
    //         $tree->disableCreate();
    //         return $tree;
    //     });
    // }

    // public function getNewsCateOptions()
    // {
    //     return DB::table('news_categories')->select('id', 'title as text')->get();
    // }
}
