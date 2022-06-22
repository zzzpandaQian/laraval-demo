<?php

namespace App\Admin\Controllers;

use App\Models\News;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\NewsTag;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Encore\Admin\Layout\Content;
use App\Imports\NewsImport;
use Excel;

class NewsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '新闻列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new News);

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('newsCategory.title', __('新闻分类'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('status', __('状态'))->display(function ($status) {
            $active = config('array.active');
            $labelStyle = ($status == 1) ? 'success' : 'warning';
            return "<span class='label label-" . $labelStyle . "'>" . $active[$status] . "</span>";
        });

        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器;
            $filter->column(1 / 2, function ($filter) {
                $filter->like('title', '标题');
                $filter->equal('status', '状态')->radio([''   => '全部'] + config('array.active'));
            });
            $filter->column(1 / 2, function ($filter) {
                $filter->equal('news_category_id', '新闻分类')->select(NewsCategory::where('status', 1)->pluck('title', 'id'));
                // 多对多关联查询
                $filter->where(function ($query) {
                    $query->whereHas('tags', function ($query) {
                        $query->where('news_tag_id', $this->input);
                    });
                }, '新闻标签', 'news_tag_id')->select(NewsTag::all()->pluck('title', 'id'));
            });
        });

        // 自定义导入
        // $grid->tools(function ($tools) {
        //     $tools->append('<a href="' . route('news.import') . '" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-open"></i> 导入新闻</a>');
        // });

        // 自定义导入
        $grid->tools(function ($tools) {
            $import_url = (request()->input('news_category_id'))
                ? route('news.import', ['news_category_id' => request()->input('news_category_id')])
                : route('news.import');
            $tools->append('<a href="' . $import_url . '" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-open"></i> 导入新闻</a>');
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
        $show = new Show(News::findOrFail($id));

        $show->field('id', __('编号'));
        $show->field('newsCategory.title', __('新闻分类'))->as(
            function ($news_category_id) {
                return optional($this->getModel()->newsCategory)->title;
            }
        );
        $show->field('title', __('标题'));
        $show->field('seo_title', __('SEO标题'));
        $show->field('seo_keywords', __('SEO关键字'));
        $show->field('seo_description', __('SEO描述'));
        $show->field('image', __('图片'))->image();
        $show->field('short', __('简介'));
        $show->field('content', __('内容'))->unescape();
        $show->field('tags', __('标签'))->as(function ($newsTag) {
            return $newsTag->pluck('name');
        })->label();
        $show->field('read_count', __('阅读次数'));
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
        $form = new Form(new News);

        $form->text('title', __('标题'))->rules('required');
        $form->select('news_category_id', '新闻分类')->options(
            function ($news_category_id) {
                return NewsCategory::where('status', 1)->pluck('title', 'id');
            }
        )->rules('required');
        $form->text('seo_title', __('SEO标题'));
        $form->text('seo_keywords', __('SEO关键字'));
        $form->textarea('seo_description', __('SEO描述'));
        $form->multipleSelect('tags', '标签')->options(NewsTag::all()->pluck('name', 'id'));
        $form->image('image', __('图片'))->move('news')->thumbnail([
            'small'  => [500, 260, 'fit'],
            'large'  => [1000, 520, 'fit'],
        ])->help('建议尺寸1000*660');;
        $form->textarea('short', __('简介'))->rows(10);
        $form->UEditor('content', '内容');
        $form->number('read_count', __('阅读次数'));
        $form->radio('status', __('状态'))->options(config('array.active'))->default('0');

        return $form;
    }

    /**
     * Undocumented function
     *
     * @param Content $content
     * @param Request $request
     * @return void
     */
    public function import(Content $content, Request $request)
    {
        $news_category_id = ($request->input('news_category_id')) ?: 0;

        if ($request->isMethod('post')) {
            $files     = $request->file('excel_file');                         //接收文件
            if (!isset($files)) {
                admin_error('请选择文件');
                return redirect(route('news.import'));
            }
            $entension = $files->getClientOriginalExtension();               //获得文件后缀名
            $tabl_name = date('YmdHis') . mt_rand(100, 999);
            $newName   = $tabl_name . '.' . $entension;                            //文件名设置
            $paths     = $request->file('excel_file')->storeAs('', $newName);  //文件上传到项目
            $import    = new NewsImport;
            $reader    = Excel::import($import, $paths);                       //导入到数据库
            admin_success('数据已导入' . $import->getSuccessRows() . '行，忽略' . $import->getFailedRows() . '行');
            return redirect(route('news.index', ['news_category_id' => $news_category_id]));
        }

        $news_category = NewsCategory::where('status', 1)->pluck('name', 'id')->toArray();

        return $content
            ->header('新闻')
            ->description('导入')
            ->body(view('admin.news.import', ['data' => $news_category, 'news_category_id' => $news_category_id]));
    }
}
