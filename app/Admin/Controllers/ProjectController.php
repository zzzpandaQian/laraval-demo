<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\Project;
use App\Models\Portfolio;
use App\Models\PortfolioIntroduction;
use Illuminate\Http\Request;
use Encore\Admin\Controllers\AdminController;

class ProjectController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '项目';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Project);

        $grid->column('id', __('ID'));
        $grid->column('portfolio.title', __('投资'));
        $grid->column('portfolioIntroduction.title', __('投资介绍'));
        $grid->column('title', __('项目'));
        $grid->column('created_at', __('创建时间'));
        $grid->filter(function ($filter) {
            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            // 在这里添加字段过滤器
            $filter->like('portfolio.title', '投资');
            $filter->like('portfolioIntroduction.title', '投资介绍');
            $filter->like('title', '项目');
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
        $show = new Show(Project::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('portfolio_id', __('Portfolio id'));
        $show->field('portfolio_introduction_id', __('Portfolio introduction id'));
        $show->field('title', __('Title'));
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
        $form = new Form(new Project);

        $form->select('portfolio_id', '投资')->options(
            function ($portfolio_id) {
                return Portfolio::where('status', 1)->pluck('title', 'id');
            }
        )->load('portfolio_introduction_id', admin_url('/project/introduction'));
        $form->select('portfolio_introduction_id', '投资介绍');

        $form->text('title', __('项目'));
        $form->textarea('description', __('描述'));

        return $form;
    }

    public function portfolioIntroduction(Request $request)
    {
        $provinceId = $request->get('q');
        $title = PortfolioIntroduction::where('portfolio_id', $provinceId)->pluck('title', 'id')->toArray();
        $data = [];
        foreach ($title as $key => $item) {
            $data[] = [
                'id' => $key,
                'text' => $title[$key],
            ];
        }
        return $data;
    }
}
